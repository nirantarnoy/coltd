<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
date_default_timezone_set('Asia/Bangkok');

class Picking extends \common\models\Picking
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

    public function findName($id){
        $model = Picking::find()->where(['id'=>$id])->one();
        return count($model)>0?$model->picking_no:'';
    }
    public function getLastNo(){
        $model = \backend\models\Picking::find()->MAX('picking_no');
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
            return 'PK'.$prefix;
        }else{
            $prefix ='PK'.substr(date("Y"),2,2);
            return $prefix.'000001';
        }
    }
    public function findSo($id){
        $model = \backend\models\Picking::find()->where(['id'=>$id])->one();
        if($model){
            $sale = \backend\models\Sale::findName($model->sale_id);
            return $sale;
        }else{
            return '';
        }
    }
    public function findCustomer($id){
        $model = \backend\models\Picking::find()->where(['id'=>$id])->one();
        if($model){
            $customer = \backend\models\Sale::find()->where(['id'=>$model->sale_id])->one();
            if($customer){
                $name = \backend\models\Customer::find()->where(['id'=>$customer->customer_id])->one();
                if($name){
                    return $name->name;
                }else{
                    return '';
                }
            }
        }else{
            return '';
        }
    }
    public function findCustomerAddress($id){
        $model = \backend\models\Picking::find()->where(['id'=>$id])->one();
        if($model){
            $customer = \backend\models\Sale::find()->where(['id'=>$model->sale_id])->one();
            if($customer){
                $name = \backend\models\Customer::find()->where(['id'=>$customer->customer_id])->one();
                if($name){
                    return $name->address;
                }else{
                    return '';
                }
            }
        }else{
            return '';
        }
    }
}
