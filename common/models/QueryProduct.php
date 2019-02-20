<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_product".
 *
 * @property int $id
 * @property string $product_code
 * @property string $name
 * @property string $description
 * @property int $category_id
 * @property string $group_name
 * @property int $unit_id
 * @property double $cost
 * @property double $price
 * @property int $status
 * @property string $engname
 * @property double $volumn
 * @property double $volumn_content
 * @property int $unit_factor
 * @property string $origin
 * @property double $netweight
 * @property double $grossweight
 * @property string $excise_no
 * @property string $geolocation
 * @property double $all_qty
 * @property double $available_qty
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
            [['id', 'category_id', 'unit_id', 'status', 'unit_factor'], 'integer'],
            [['cost', 'price', 'volumn', 'volumn_content', 'netweight', 'grossweight', 'all_qty', 'available_qty'], 'number'],
            [['product_code', 'name', 'description', 'group_name', 'engname', 'origin', 'excise_no', 'geolocation'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_code' => 'Product Code',
            'name' => 'Name',
            'description' => 'Description',
            'category_id' => 'Category ID',
            'group_name' => 'Group Name',
            'unit_id' => 'Unit ID',
            'cost' => 'Cost',
            'price' => 'Price',
            'status' => 'Status',
            'engname' => 'Engname',
            'volumn' => 'Volumn',
            'volumn_content' => 'Volumn Content',
            'unit_factor' => 'Unit Factor',
            'origin' => 'Origin',
            'netweight' => 'Netweight',
            'grossweight' => 'Grossweight',
            'excise_no' => 'Excise No',
            'geolocation' => 'Geolocation',
            'all_qty' => 'All Qty',
            'available_qty' => 'Available Qty',
        ];
    }
}
