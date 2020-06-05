<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
date_default_timezone_set('Asia/Bangkok');

class Currencyrate extends \common\models\CurrencyRate
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

            'timestampupdate'=>[
                'class'=> \yii\behaviors\AttributeBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_UPDATE=>'updated_at',
                ],
                'value'=> time(),
            ],
        ];
    }

    public function findRate($cur,$type){
        $model = \backend\models\Currencyrate::find()->where(['from_currency'=>$cur,'rate_type'=>$type])->one();
        return $model!=null?$model:null;
    }
    public function findRateMonth($currency,$month,$type){
        if($currency){
          //  $model = \backend\models\Currencyrate::find()->where(['from_currency'=>$currency,'MONTH(to_date)'=>$month,'rate_type'=>$type])->one();
            $model = \backend\models\Currencyrate::find()->where(['from_currency'=>$currency,'rate_type'=>$type])->one();
            return count($model)>0?$model:null;
        }
    }

//    public function findRateImport($currency){
//        $month = date('m');
//        if($currency){
//            //  $model = \backend\models\Currencyrate::find()->where(['from_currency'=>$currency,'MONTH(to_date)'=>$month,'rate_type'=>$type])->one();
//            $model = \backend\models\Currencyrate::find()->where(['from_currency'=>$currency,'rate_type'=>1])->andFilterWhere(['AND',['>=','MONTH(from_date)',$month],['<=','MONTH(to_date)',$month]])->one();
//            return $model != null?$model:null;
//        }
//    }
    public function findRateImport($currency){
        $month = date('m');

        $max_from_date = null;
        $max_to_date = null;

        if($currency){
            $modelx = \backend\models\Currencyrate::find(['from_currency'=>$currency,'rate_type'=>1])->max('to_date');
            //  $model = \backend\models\Currencyrate::find()->where(['from_currency'=>$currency,'MONTH(to_date)'=>$month,'rate_type'=>$type])->one();
            $model = \backend\models\Currencyrate::find()->where(['from_currency'=>$currency,'rate_type'=>1])->andFilterWhere(['AND',['>=','MONTH(from_date)',$month],['<=','MONTH(to_date)',$month]])->one();
            //print_r($modelx);return;
            if($model != null){
                return $model != null?$model:null;
            }else{
                if($modelx != null){
                    $max_to_date = date('m',strtotime($modelx));
                    $model2 = \backend\models\Currencyrate::find()->where(['from_currency'=>$currency])->andFilterWhere(['<=','MONTH(to_date)',$max_to_date])->one();
                    if($model2 != null){
                        return $model2 != null?$model2:null;
                    }
                }

            }

        }else{
            return null;
        }
    }
}
