<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_inbound".
 *
 * @property string $invoice_no
 * @property string $invoice_date
 * @property int $supplier_id
 * @property string $docin_no
 * @property string $permit_no
 * @property string $permit_date
 * @property string $transport_in_no
 * @property string $transport_in_date
 * @property int $line_qty
 * @property double $line_price
 * @property string $name
 * @property string $currency_name
 * @property double $rate
 * @property string $unit_name
 * @property string $category_name
 */
class QueryInbound extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_inbound';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoice_date', 'permit_date', 'transport_in_date'], 'safe'],
            [['supplier_id', 'line_qty'], 'integer'],
            [['line_price', 'currency_rate'], 'number'],
            [['invoice_no', 'docin_no', 'permit_no', 'transport_in_no', 'name', 'currency_name', 'unit_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'invoice_no' => 'Invoice No',
            'invoice_date' => 'Invoice Date',
            'supplier_id' => 'Supplier ID',
            'docin_no' => 'Docin No',
            'permit_no' => 'Permit No',
            'permit_date' => 'Permit Date',
            'transport_in_no' => 'Transport In No',
            'transport_in_date' => 'Transport In Date',
            'line_qty' => 'Line Qty',
            'line_price' => 'Line Price',
            'name' => 'Name',
            'currency_name' => 'Currency Name',
            'currency_rate' => 'Rate',
            'unit_name' => 'Unit Name',
        ];
    }
}
