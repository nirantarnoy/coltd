<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
date_default_timezone_set('Asia/Bangkok');

class Inboundinv extends \common\models\InboundInv
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
    public static function getLastNo(){
        $model = Inboundinv::find()->MAX('invoice_no');
        //$pre = \backend\models\Sequence::find()->where(['module_id'=>15])->one();
        $pre = "JL";
        if($model){
            $prefix = $pre.substr(date("Y"),2,2);
            $cnum = substr((string)$model,4,strlen($model));
            $len = strlen($cnum);
            $clen = strlen($cnum + 1);
            $loop = $len - $clen;
            for($i=1;$i<=$loop;$i++){
                $prefix.="0";
            }
            $prefix.=$cnum + 1;
            return $prefix;
        }else{
            $prefix =$pre.substr(date("Y"),2,2);
            return $prefix.'000001';
        }
    }
    public function findId($inv_no){
        $model = Inboundinv::find()->where(['invoice_no'=>trim($inv_no)])->one();
        return count($model)>0?$model->id:0;
    }
    public function findNum($id){
        $model = Inboundinv::find()->where(['id'=>$id])->one();
        return count($model)>0?$model->invoice_no:'';
    }
    public function findTrans($id){
        $model = \backend\models\Importline::find()->where(['import_id'=>$id])->one();
        return count($model)>0?1:0;
    }
//    public function findName($id){
//        $model = Customer::find()->where(['id'=>$id])->one();
//        return count($model)>0?$model->name:'';
//    }
//    public function findFullName($id){
//        $model = Customer::find()->where(['id'=>$id])->one();
//        return count($model)>0?$model->code." ".$model->name:'';
//    }
//    public function findInfo($id){
//        $model = Customer::find()->where(['id'=>$id])->one();
//        return $model;
//    }

}
