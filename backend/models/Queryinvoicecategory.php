<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

date_default_timezone_set('Asia/Bangkok');

class Queryinvoicecategory extends \common\models\QueryInvoiceCategory
{

    public function findCat($inv_no)
    {
        $model = \backend\models\Queryinvoicecategory::find()->where(['docin_no' => $inv_no])->all();
        $cat = '';
        if ($model) {
            $data = [];
            $i = 0;
            foreach ($model as $val) {
                if(in_array($val->name,$data)){
                    continue;
                }else{
                    array_push($data,$val->name);
                }
                if ($i == 0 && $i < count($model)) {
                    $cat .= $val->name.',';
                } else if ($i >0 && $i < count($model)) {
                    $cat .= $val->name . ',';
                } else if ($i == count($model)) {
                    $cat .= $val->name;
                }

            }
        }
        return $cat;
    }
}
