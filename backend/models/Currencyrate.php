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
            $model = \backend\models\Currencyrate::find()->where(['from_currency'=>$currency,'MONTH(from_date)'=>$month,'rate_type'=>$type])->one();
            return count($model)>0?$model:null;
        }
    }
}
