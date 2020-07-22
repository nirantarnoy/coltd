<?php

namespace backend\models;

use backend\models\Product;
use backend\models\Journal;
use backend\models\Journaltrans;
use backend\helpers\TransType;
use backend\models\Stockbalance;

class TransCalculate extends \yii\base\Model
{
    /**
     * @param $data
     * @return bool
     */
    public static function createJournal($data)
    {
        if ($data) {
            $model_journal = new Journal();
            $model_journal->journal_no = $model_journal::getLastNo();
            $model_journal->trans_type = $data[0]['trans_type'];
            if ($model_journal->save()) {
                return self::createJournalline($model_journal->id, $data);
            } else {
                return false;
            }
        }

    }

    public static function createJournalline($jour_id, $data)
    {
        $res = false;
        if ($data) {
            for ($i = 0; $i <= count($data) - 1; $i++) {
                $param = [];
                $stocktype = 0;

                if ($data[$i]['trans_type'] == TransType::TRANS_PICKING) {
                    $stocktype = 1;
                } // 0 in 1 out
                if ($data[$i]['trans_type'] == TransType::TRANS_ADJUST_IN) {
                    $stocktype = 0;
                } // 0 in 1 out
                if ($data[$i]['trans_type'] == TransType::TRANS_ADJUST_OUT) {
                    $stocktype = 1;
                } // 0 in 1 out

                $model_journalline = new Journaltrans();
                $model_journalline->journal_id = $jour_id;
                $model_journalline->product_id = $data[$i]['prod_id'];
                $model_journalline->to_wh = $data[$i]['warehouse_id'];
                $model_journalline->qty = $data[$i]['qty'];
                $model_journalline->stock_type = $stocktype;
                $model_journalline->trans_date = date('Y-m-d');
                if ($model_journalline->save()) {
                    if (self::createStocksum($data[$i], $stocktype)) {
                        $res = true;
                    }
                }
            }

        }
        return $res;
    }

    public static function createStocksum($param, $stocktype)
    {
        if ($param) {
            $model_stock = null;

            if($param['stock_id_ref'] != ''){
                $model_stock = Productstock::find()
                    ->where(['id' => $param['stock_id_ref']])
                    ->one();
            }else{
                $model_stock = Productstock::find()
                    ->where(['product_id' => $param['prod_id'],
                        'warehouse_id' => $param['warehouse_id'],
                        'invoice_no' => $param['invoice_no'],
                        'transport_in_no' => $param['transport_in_no'],
                        'permit_no' => $param['permit_no']
                    ])
                    ->one();
            }

            if ($model_stock) {
                if ($stocktype == 1) { // picking out
                    $model_stock->qty = (int)$model_stock->qty - (int)$param['qty'];
                } else {
                    $model_stock->qty = (int)$model_stock->qty + (int)$param['qty'];
                }

                if ($model_stock->save(false)) {
                    return self::updateProductInvent($param['prod_id']);
                } else {
                    return false;
                }

            } else {
//              if($stocktype==1){
//
//              }else{
                $qty_in = 0;
                $qty = 0;
                $qty_out = 0;
                $trans_no = '';
                $trans_date = '';
                $permit_date = '';
                $kno_no = '';
                $kno_date = '';

                if ($stocktype == 1) { // picking out
                    $qty_out = $param['qty'];
                    $qty = ((int)$param['qty'] * -1);

                    $trans_no = $param['transport_out_no'];
                    $trans_date = date('Y-m-d', strtotime($param['transport_out_date']));
                    $permit_date = date('Y-m-d', strtotime($param['permit_date']));
                    $kno_no = $param['kno_out_no'];
                    $kno_date = date('Y-m-d', strtotime($param['kno_out_date']));
                } else {
                    $qty_in = $param['qty'];
                    $qty = $param['qty'];

                    $trans_no = $param['transport_in_no'];
                    $trans_date = date('Y-m-d', strtotime($param['transport_in_date']));
                    $permit_date = date('Y-m-d', strtotime($param['permit_date']));
                    $kno_no = $param['kno_no_in'];
                    $kno_date = date('Y-m-d', strtotime($param['kno_in_date']));
                }

                $modelstock = new Productstock();
                $modelstock->product_id = $param['prod_id'];
                $modelstock->warehouse_id = $param['warehouse_id'];
                $modelstock->invoice_no = $param['invoice_no'];
                $modelstock->invoice_date = date('Y-m-d',strtotime($param['invoice_date']));
                $modelstock->transport_in_no = $trans_no;
                $modelstock->transport_in_date = $trans_date;
                $modelstock->sequence = $param['sequence'];
                $modelstock->permit_no = $param['permit_no'];
                $modelstock->permit_date = $permit_date;
                $modelstock->kno_no_in = $kno_no;
                $modelstock->kno_in_date = $kno_date;
                $modelstock->in_qty = $qty_in;
                $modelstock->qty = $qty;
                $modelstock->out_qty = $qty_out;
                $modelstock->usd_rate = $param['usd_rate'];
                $modelstock->thb_amount = $param['thb_amount'];
                if(isset($param['inbound_id'])){
                    $modelstock->inbound_id = $param['inbound_id'];
                }
                if(isset($param['outbound_id'])){
                    $modelstock->outbound_id = $param['outbound_id'];
                }


                if ($modelstock->save(false)) {
                    return self::updateProductInvent($param['prod_id']);
                } else {
                    return false;
                }
//              }
                //self::updateProductInvent($param[0]['prod_id']);
            }
        } else {
            return true;
        }
    }

    public static function updateProductInvent($product_id)
    {
        $sum_all = Productstock::find()->where(['product_id' => $product_id])->sum('qty');
        // $sum_all = Stockbalance::find()->where(['product_id'=>$product_id])->sum('qty');
        // $sum_reserve = Stockbalance::find()->where(['product_id'=>$product_id])->sum('quantity');

        $model_product = Product::find()->where(['id' => $product_id])->one();
        if ($model_product) {
            $model_product->all_qty = $sum_all;
            $model_product->available_qty = $model_product->all_qty;
            //    $model_product->available_qty = $model_product->all_qty - (int)$model_product->reserved_qty;
            $model_product->save(false);
        }
        return true;
    }
}
