<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $product_code
 * @property string $name
 * @property string $description
 * @property string $barcode
 * @property string $photo
 * @property int $category_id
 * @property int $product_type_id
 * @property int $unit_id
 * @property double $min_stock
 * @property double $max_stock
 * @property int $is_hold
 * @property int $has_variant
 * @property int $bom_type
 * @property double $cost
 * @property double $price
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'product_type_id', 'unit_id', 'is_hold', 'has_variant', 'bom_type', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['min_stock', 'max_stock', 'cost', 'price'], 'number'],
            [['product_code', 'name', 'description', 'barcode', 'photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_code' => Yii::t('app', 'Product Code'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'barcode' => Yii::t('app', 'Barcode'),
            'photo' => Yii::t('app', 'Photo'),
            'category_id' => Yii::t('app', 'Category ID'),
            'product_type_id' => Yii::t('app', 'Product Type ID'),
            'unit_id' => Yii::t('app', 'Unit ID'),
            'min_stock' => Yii::t('app', 'Min Stock'),
            'max_stock' => Yii::t('app', 'Max Stock'),
            'is_hold' => Yii::t('app', 'Is Hold'),
            'has_variant' => Yii::t('app', 'Has Variant'),
            'bom_type' => Yii::t('app', 'Bom Type'),
            'cost' => Yii::t('app', 'Cost'),
            'price' => Yii::t('app', 'Price'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
}
