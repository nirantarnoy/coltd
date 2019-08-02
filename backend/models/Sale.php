<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
date_default_timezone_set('Asia/Bangkok');
class Sale extends \common\models\Sale{
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
    public function findName($id){
        $model = Sale::find()->where(['id'=>$id])->one();
        return count($model)>0?$model->sale_no:'';
    }
    public function getLastNo(){
        $model = \backend\models\Sale::find()->MAX('sale_no');
//        $pre = \backend\models\Sequence::find()->where(['module_id'=>$trans_type])->one();
        if($model){
            $prefix = substr(date("Y"),2,2);
            $cnum = substr((string)$model,4,strlen($model));
            $len = strlen($cnum);
            $clen = strlen($cnum + 1);
            $loop = $len - $clen;
            for($i=1;$i<=$loop;$i++){
                $prefix.="0";
            }
            $prefix.=$cnum + 1;
            return 'IV'.$prefix;
        }else{
            $prefix ='IV'.substr(date("Y"),2,2);
            return $prefix.'000001';
        }
    }
}
