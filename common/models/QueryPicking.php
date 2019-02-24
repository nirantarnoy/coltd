<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_picking".
 *
 * @property string $sale_no
 * @property int $created_at
 * @property int $require_date
 * @property int $currency
 * @property int $customer_id
 * @property int $trans_date
 * @property int $product_id
 * @property double $qty
 * @property int $status
 * @property double $price
 * @property string $permit_no
 * @property string $permit_date
 * @property string $transport_in_no
 * @property string $transport_in_date
 * @property string $excise_no
 * @property string $excise_date
 * @property int $warehouse_id
 * @property string $name
 * @property string $engname
 * @property int $category_id
 * @property string $product_group
 * @property string $customer_name
 * @property int $currency_id
 * @property string $currency_name
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
            [['created_at', 'require_date', 'currency', 'customer_id', 'trans_date', 'product_id', 'status', 'warehouse_id', 'category_id', 'currency_id'], 'integer'],
            [['qty', 'price'], 'number'],
            [['permit_date', 'transport_in_date', 'excise_date'], 'safe'],
            [['picking_date'],'date'],
            [['sale_no','unit_name', 'permit_no', 'transport_in_no', 'excise_no', 'name', 'engname', 'product_group', 'customer_name', 'currency_name','country_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sale_no' => 'Sale No',
            'created_at' => 'Created At',
            'require_date' => 'Require Date',
            'currency' => 'Currency',
            'customer_id' => 'Customer ID',
            'trans_date' => 'Trans Date',
            'product_id' => 'Product ID',
            'product_group' => 'รายการสินค้า',
            'picking_date' => 'วันดือนปี',
            'month' =>'เดือน',
            'qty' => 'จำนวน',
            'status' => 'Status',
            'price' => 'รวม',
            'permit_no' => 'Permit No',
            'permit_date' => 'Permit Date',
            'transport_in_no' => 'เลขที่ใบขนเข้า',
            'transport_in_date' => 'Transport In Date',
            'excise_no' => 'Excise No',
            'excise_date' => 'Excise Date',
            'warehouse_id' => 'Warehouse ID',
            'name' => 'Name',
            'unit_name'=>'หน่วยนับ',
            'engname' => 'Engname',
            'country_name' => 'ขายไปยัง',
            'category_id' => 'Category ID',
            'customer_name' => 'ลูกค้า/ลูกหนี้',
            'currency_id' => 'Currency ID',
            'currency_name' => 'Currency Name',
        ];
    }
}
