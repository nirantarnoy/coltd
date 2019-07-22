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
    public static function createJournal($data){
        if($data){
            $model_journal = new Journal();
            $model_journal->journal_no = $model_journal::getLastNo();
            $model_journal->trans_type = $data[0]['trans_type'] ;
            if($model_journal->save()){
                return self::createJournalline($model_journal->id,$data);
            }else{
                return false;
            }
        }

    }
    public static function createJournalline($jour_id,$data){
      if($data){
          for($i=0;$i<=count($data)-1;$i++){
              $param = [];
              $stocktype = 0;

              if($data[$i]['trans_type'] == TransType::TRANS_PICKING){$stocktype = 1;} // 0 in 1 out
              if($data[$i]['trans_type'] == TransType::TRANS_ADJUST_IN){$stocktype = 0;} // 0 in 1 out
              if($data[$i]['trans_type'] == TransType::TRANS_ADJUST_OUT){$stocktype = 1;} // 0 in 1 out

              $model_journalline = new Journaltrans();
              $model_journalline->journal_id = $jour_id;
              $model_journalline->product_id = $data[$i]['prod_id'];
              $model_journalline->to_wh = $data[$i]['warehouse_id'];
              $model_journalline->qty = $data[$i]['qty'];
              $model_journalline->stock_type = $stocktype;
              $model_journalline->trans_date = date('Y-m-d');
              if($model_journalline->save()){
                  array_push($param,[
                      'prod_id'=>$data[$i]['prod_id'],
                      'warehouse_id'=>$data[$i]['warehouse_id'],
                      'qty'=>$data[$i]['qty'],
                      'trans_type'=>$data[$i]['trans_type'],
                      'invoice_no' => $data[$i]['invoice_no'],
                      'invoice_date' => $data[$i]['invoice_date'],
                      'permit_no' => $data[$i]['permit_no'],
                      'permit_date' => $data[$i]['permit_date'],
                      'transport_in_no' => $data[$i]['transport_in_no'],
                      'transport_in_date' => $data[$i]['transport_in_date'],
                      'excise_no' => $data[$i]['excise_no'],
                      'stock_type' => $stocktype,
                      'thb_amount' => $data[$i]['thb_amount'],
                      'usd_rate' =>$data[$i]['usd_rate'],
                  ]);
                self::createStocksum($param);
              }
          }

      }
    }
    public static function createStocksum($param){
       if($param){
//          $model_stock = Stockbalance::find()
//              ->where(['product_id'=>$param[0]['prod_id'],
//                       'warehouse_id'=>$param[0]['warehouse_id'],
//                       'permit_no'=>$param[0]['permit_no'],
//                       'transport_in_no'=>$param[0]['transport_in_no'],
//                       'excise_no'=>$param[0]['excise_no'],
//              ])
//              ->one();
           $model_stock = Productstock::find()
               ->where(['product_id'=>$param[0]['prod_id'],
                   'warehouse_id'=>$param[0]['warehouse_id'],
                   'invoice_no'=>$param[0]['invoice_no'],
                   'transport_in_no'=>$param[0]['transport_in_no']
               ])
               ->one();
          if($model_stock){
              if($param[0]['stock_type']==1){ // picking
                  $model_stock->qty = $model_stock->qty - $param[0]['qty'];
              }else{
                  $model_stock->qty = $model_stock->qty + $param[0]['qty'];
              }

              if($model_stock->save(false)){
                  self::updateProductInvent($param[0]['prod_id']);
              }else{
                 return false;
              }

          }else{
              if($param[0]['stock_type']==1){

              }else{
//                  $model = new Stockbalance();
//                  $model->product_id = $param[0]['prod_id'];
//                  $model->warehouse_id = $param[0]['warehouse_id'];
//                  $model->permit_no = $param[0]['permit_no'];
//                  $model->transport_in_no = $param[0]['transport_no'];
//                  $model->excise_no = $param[0]['excise_no'];
//                  $model->qty = $param[0]['qty'];
//                  if($model->save()){
//                      self::updateProductInvent($param[0]['prod_id']);
//                  }
                  $modelstock = new Productstock();
                  $modelstock->product_id = $param[0]['prod_id'];
                  $modelstock->warehouse_id = $param[0]['warehouse_id'];
                  $modelstock->invoice_no = $param[0]['invoice_no'];
                  $modelstock->invoice_date = date('Y-m-d',strtotime($param[0]['invoice_date']));
                  $modelstock->transport_in_no = $param[0]['transport_in_no'];
                  $modelstock->transport_in_date = date('Y-m-d',strtotime( $param[0]['transport_in_date']));
                 // $modelstock->sequence = $rowData[15];
                  $modelstock->permit_no = $param[0]['permit_no'];
                  $modelstock->permit_date = date('Y-m-d',strtotime($param[0]['permit_date']));
                  //$modelstock->kno_no_in = $rowData[18];
                 // $modelstock->kno_in_date = date('Y-m-d',strtotime($rowData[19]));
                  $modelstock->in_qty = $param[0]['qty'];
                  $modelstock->out_qty = 0;
                  $modelstock->usd_rate = $param[0]['usd_rate'];
                  $modelstock->thb_amount =  $param[0]['thb_amount'];
                  if($modelstock->save(false)){
                      self::updateProductInvent($param[0]['prod_id']);
                  }
              }
              //self::updateProductInvent($param[0]['prod_id']);
          }
       }else{
           return true;
       }
    }
    public static function updateProductInvent($product_id){
        $sum_all = Productstock::find()->where(['product_id'=>$product_id])->sum('in_qty');
       // $sum_all = Stockbalance::find()->where(['product_id'=>$product_id])->sum('qty');
        // $sum_reserve = Stockbalance::find()->where(['product_id'=>$product_id])->sum('quantity');

           $model_product = Product::find()->where(['id'=>$product_id])->one();
           if($model_product){
               $model_product->all_qty = $sum_all ;
               $model_product->available_qty = $model_product->all_qty;
           //    $model_product->available_qty = $model_product->all_qty - (int)$model_product->reserved_qty;
               $model_product->save(false);
           }
           return true;
    }
}
