<?php
namespace backend\models;

use backend\models\Product;
use backend\models\Journal;
use backend\models\Journalline;
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
            $model_journal->journal_no = "Test";
            $model_journal->trans_type = TransType::TRANS_ADJUST ;
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

              $model_journalline = new Journalline();
              $model_journalline->journal_id = $jour_id;
              $model_journalline->product_id = $data[$i]['prod_id'];
              $model_journalline->to_wh = $data[$i]['warehouse_id'];
              $model_journalline->qty = $data[$i]['qty'];
              if($model_journalline->save()){
                  array_push($param,['prod_id'=>$data[$i]['prod_id'],'warehouse_id'=>$data[$i]['warehouse_id'],'qty'=>$data[$i]['qty']]);
                self::createStocksum($param);
              }
          }

      }
    }
    public static function createStocksum($param){
       if($param){
          $model_stock = Stockbalance::find()->where(['product_id'=>$param[0]['prod_id'],'warehouse_id'=>$param[0]['warehouse_id']])->one();
          if($model_stock){
              $model_stock->quantity = $model_stock->quantity + $param[0]['qty'];
              if($model_stock->save(false)){
                  self::updateProductInvent($param[0]['prod_id']);
              }else{
                 return false;
              }

          }else{
              $model = new Stockbalance();
              $model->product_id = $param[0]['prod_id'];
              $model->warehouse_id = $param[0]['warehouse_id'];
              $model->quantity = $param[0]['qty'];
              if($model->save()){
                  self::updateProductInvent($param[0]['prod_id']);
              }

          }
       }else{
           return true;
       }
    }
    public static function updateProductInvent($product_id){
           $sum_all = Stockbalance::find()->where(['product_id'=>$product_id])->sum('quantity');
       // $sum_reserve = Stockbalance::find()->where(['product_id'=>$product_id])->sum('quantity');

           $model_product = Product::find()->where(['id'=>$product_id])->one();
           if($model_product){
               $model_product->all_qty = $sum_all ;
               $model_product->available_qty = $model_product->all_qty - (int)$model_product->reserved_qty;
               $model_product->save(false);
           }
    }
}