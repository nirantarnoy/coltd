<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_invoice_out_category".
 *
 * @property string $picking_no
 * @property string $sale_no
 * @property string $name
 */
class QueryInvoiceOutCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_invoice_out_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['picking_no', 'sale_no', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'picking_no' => 'Picking No',
            'sale_no' => 'Sale No',
            'name' => 'Name',
        ];
    }
}
