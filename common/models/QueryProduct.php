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
 * @property string $excise_no
 * @property string $excise_date
 * @property string $group_name
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
            [['id', 'category_id', 'product_type_id', 'unit_id', 'is_hold', 'bom_type', 'status'], 'integer'],
            [['min_stock', 'max_stock', 'cost', 'price', 'all_qty', 'unit_factor', 'volumn_content', 'volumn', 'netweight', 'grossweight'], 'number'],
            [['excise_date'], 'safe'],
            [['product_code', 'name', 'description', 'barcode', 'origin', 'engname', 'excise_no', 'group_name'], 'string', 'max' => 255],
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
            'excise_no' => 'Excise No',
            'excise_date' => 'Excise Date',
            'group_name' => 'Group Name',
        ];
    }
}
