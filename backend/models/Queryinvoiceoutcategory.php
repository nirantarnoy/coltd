<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

date_default_timezone_set('Asia/Bangkok');

class Queryinvoiceoutcategory extends \common\models\QueryInvoiceOutCategory
{

    public function findCat($sale_no)
    {
        $model = Queryinvoiceoutcategory::find()->where(['sale_no' => $sale_no])->all();
        $cat = '';
        if ($model) {
            $i = 0;
            foreach ($model as $val) {
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
