<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
date_default_timezone_set('Asia/Bangkok');

class Productstock extends \common\models\ProductStock
{
    public function behaviors()
    {
        return [
            'timestampcdate'=>[
                'class'=> \yii\behaviors\AttributeBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>'created_at',
                ],
                'value'=> time(),
            ],
            'timestampudate'=>[
                'class'=> \yii\behaviors\AttributeBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>'updated_at',
                ],
                'value'=> time(),
            ],
            'timestampcby'=>[
                'class'=> \yii\behaviors\AttributeBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>'created_by',
                ],
                'value'=> Yii::$app->user->identity->id,
            ],
            'timestamuby'=>[
                'class'=> \yii\behaviors\AttributeBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_UPDATE=>'updated_by',
                ],
                'value'=> Yii::$app->user->identity->id,
            ],
            'timestampupdate'=>[
                'class'=> \yii\behaviors\AttributeBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_UPDATE=>'updated_at',
                ],
                'value'=> time(),
            ],
        ];
    }
    public function getProduct(){
        return $this->hasOne(\backend\models\Product::className(),['id'=>'product_id']);
    }

    public function getWarehouse(){
        return $this->hasOne(\backend\models\Warehouse::className(),['id'=>'warehouse_id']);
    }
    public function findUSDPriceCarton($product_id)
    {
        $model = \backend\models\Productstock::find()->where(['product_id' => $product_id])->one();
        return count($model) > 0 ? $model->usd_rate : 0;
    }
    public function findStockInfo($stock_id)
    {
        $model = \backend\models\Productstock::find()->where(['stock_id_ref' => $stock_id])->one();
        return count($model) > 0 ? $model : null;
    }
    public function findTHBPriceCarton($product_id)
    {
        $model = \backend\models\Productstock::find()->where(['product_id' => $product_id])->one();
        return count($model) > 0 ? $model->thb_amount : 0;
    }

//    public function findLocationinfo($id){
//        $model = Location::find()->where(['id'=>$id])->one();
//        return count($model)>0?$model:null;
//    }
//    public function findLocationname($id){
//        $model = Location::find()->where(['id'=>$id])->one();
//        return count($model)>0?$model->name:'';
//    }

}
