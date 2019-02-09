<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_trans".
 *
 * @property int $id
 * @property string $product_code
 * @property string $name
 * @property string $description
 * @property int $unit_id
 * @property int $category_id
 * @property int $product_type_id
 * @property int $status
 * @property double $all_qty
 * @property int $journal_id
 * @property int $stock_type
 * @property double $qty
 * @property string $journal_no
 * @property double $volumn
 * @property string $engname
 * @property double $volumn_content
 * @property int $unit_factor
 * @property string $origin
 * @property double $netweight
 * @property double $grossweight
 */
class QueryTrans extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_trans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'unit_id', 'category_id', 'product_type_id', 'status', 'journal_id', 'stock_type', 'unit_factor'], 'integer'],
            [['all_qty', 'qty', 'volumn', 'volumn_content', 'netweight', 'grossweight','stock_in','stock_out','cost'], 'number'],
            [['product_code', 'name', 'description', 'journal_no', 'engname', 'origin'], 'string', 'max' => 255],
            [['trans_date'],'safe'],
            [['journal_date'],'date']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_code' => 'รหัสสินค้า',
            'name' => 'ชื่อภาษาไทย',
            'description' => 'Description',
            'unit_id' => 'Unit ID',
            'category_id' => 'Category ID',
            'product_type_id' => 'Product Type ID',
            'status' => 'Status',
            'all_qty' => 'All Qty',
            'journal_id' => 'Journal ID',
            'stock_type' => 'Stock Type',
            'qty' => 'Qty',
            'cost' => 'Cost',
            'journal_no' => 'Journal No',
            'volumn' => 'ปริมาณต่อขวด(ลิตร)',
            'engname' => 'รายละเอียดสินค้า',
            'volumn_content' => 'Alcohol Content',
            'unit_factor' => 'ปริมาณขวด(ต่อ1ลัง)',
            'origin' => 'Origin',
            'netweight' => 'Netweight',
            'grossweight' => 'Grossweight',
            'journal_date' => 'วันที่',
            'stock_in' => 'เข้า',
            'stock_out' => 'ออก'
        ];
    }
}
