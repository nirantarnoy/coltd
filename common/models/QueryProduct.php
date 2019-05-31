<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_product".
 *
 * @property string $product_code
 * @property string $name
 * @property int $id
 * @property string $description
 * @property int $category_id
 * @property int $product_type_id
 * @property int $unit_id
 * @property double $min_stock
 * @property double $max_stock
 * @property string $barcode
 * @property int $is_hold
 * @property int $bom_type
 * @property double $cost
 * @property double $price
 * @property int $status
 * @property double $all_qty
 * @property string $origin
 * @property double $unit_factor
 * @property double $volumn_content
 * @property double $volumn
 * @property string $engname
 * @property double $netweight
 * @property double $grossweight
 * @property string $excise_date
 * @property string $group_name
 * @property int $warehouse_id
 * @property string $warehouse_name
 * @property int $in_qty
 * @property int $out_qty
 * @property string $invoice_no
 * @property string $invoice_date
 * @property string $transport_in_no
 * @property string $transport_in_date
 * @property int $sequence
 * @property string $permit_no
 * @property string $permit_date
 * @property string $kno_no_in
 * @property string $kno_in_date
 * @property string $excise_no
 * @property double $usd_rate
 * @property double $thb_amount
 * @property int $stock_status
 * @property int $stock_id
 */
class QueryProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'product_type_id', 'unit_id', 'is_hold', 'bom_type', 'status', 'warehouse_id', 'in_qty', 'out_qty', 'sequence', 'stock_status', 'stock_id'], 'integer'],
            [['min_stock', 'max_stock', 'cost', 'price', 'all_qty', 'unit_factor', 'volumn_content', 'volumn', 'netweight', 'grossweight', 'usd_rate', 'thb_amount'], 'number'],
            [['excise_date'], 'safe'],
            [['product_code', 'name', 'description', 'barcode', 'origin', 'engname', 'group_name', 'warehouse_name', 'invoice_no', 'transport_in_no', 'permit_no', 'kno_no_in', 'excise_no'], 'string', 'max' => 255],
            [['invoice_date', 'transport_in_date', 'permit_date', 'kno_in_date'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_code' => 'Product Code',
            'name' => 'Name',
            'id' => 'ID',
            'description' => 'Description',
            'category_id' => 'Category ID',
            'product_type_id' => 'Product Type ID',
            'unit_id' => 'Unit ID',
            'min_stock' => 'Min Stock',
            'max_stock' => 'Max Stock',
            'barcode' => 'Barcode',
            'is_hold' => 'Is Hold',
            'bom_type' => 'Bom Type',
            'cost' => 'Cost',
            'price' => 'Price',
            'status' => 'Status',
            'all_qty' => 'All Qty',
            'origin' => 'Origin',
            'unit_factor' => 'Unit Factor',
            'volumn_content' => 'Volumn Content',
            'volumn' => 'Volumn',
            'engname' => 'Engname',
            'netweight' => 'Netweight',
            'grossweight' => 'Grossweight',
            'excise_date' => 'Excise Date',
            'group_name' => 'Group Name',
            'warehouse_id' => 'Warehouse ID',
            'warehouse_name' => 'Warehouse Name',
            'in_qty' => 'In Qty',
            'out_qty' => 'Out Qty',
            'invoice_no' => 'Invoice No',
            'invoice_date' => 'Invoice Date',
            'transport_in_no' => 'Transport In No',
            'transport_in_date' => 'Transport In Date',
            'sequence' => 'Sequence',
            'permit_no' => 'Permit No',
            'permit_date' => 'Permit Date',
            'kno_no_in' => 'Kno No In',
            'kno_in_date' => 'Kno In Date',
            'excise_no' => 'Excise No',
            'usd_rate' => 'Usd Rate',
            'thb_amount' => 'Thb Amount',
            'stock_status' => 'Stock Status',
            'stock_id' => 'Stock ID',
        ];
    }
}
