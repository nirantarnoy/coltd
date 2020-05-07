<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_picking".
 *
 * @property string $picking_no
 * @property int $month
 * @property string $picking_date
 * @property double $qty
 * @property string $unit_name
 * @property string $permit_no
 * @property string $permit_date
 * @property string $inv_no
 * @property double $price
 * @property string $inv_date
 * @property string $trans_out_no
 * @property string $kno_out_no
 * @property string $kno_out_date
 * @property string $transport_out_no
 * @property string $transport_out_date
 * @property string $customer_name
 * @property int $customer_country
 * @property string $country_name
 * @property string $product_group
 * @property int $payment_status
 * @property string $note
 * @property int $currency
 * @property string $currency_name
 * @property double $rate_factor
 * @property string $sale_no
 * @property double $rate
 */
class QueryPicking extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_picking';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month', 'customer_country', 'payment_status', 'currency'], 'integer'],
            [['picking_date', 'permit_date', 'inv_date', 'kno_out_date', 'transport_out_date'], 'safe'],
            [['qty', 'price', 'rate_factor', 'rate'], 'number'],
            [[ 'unit_name', 'permit_no', 'inv_no', 'trans_out_no', 'kno_out_no', 'transport_out_no', 'customer_name', 'product_group', 'note', 'currency_name', 'sale_no'], 'string', 'max' => 255],
            [['country_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            //'picking_no' => 'Picking No',
            'month' => 'Month',
            'picking_date' => 'Picking Date',
            'qty' => 'Qty',
            'unit_name' => 'Unit Name',
            'permit_no' => 'Permit No',
            'permit_date' => 'Permit Date',
            'inv_no' => 'Inv No',
            'price' => 'Price',
            'inv_date' => 'Inv Date',
            'trans_out_no' => 'Trans Out No',
            'kno_out_no' => 'Kno Out No',
            'kno_out_date' => 'Kno Out Date',
            'transport_out_no' => 'Transport Out No',
            'transport_out_date' => 'Transport Out Date',
            'customer_name' => 'Customer Name',
            'customer_country' => 'Customer Country',
            'country_name' => 'Country Name',
            'product_group' => 'Product Group',
            'payment_status' => 'Payment Status',
            'note' => 'Note',
            'currency' => 'Currency',
            'currency_name' => 'Currency Name',
            'rate_factor' => 'Rate Factor',
            'sale_no' => 'Sale No',
            'rate' => 'Rate',
        ];
    }
}
