<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale_line".
 *
 * @property int $id
 * @property int $sale_id
 * @property int $product_id
 * @property string $noneitem_name
 * @property double $qty
 * @property double $price
 * @property double $disc_amount
 * @property double $disc_percent
 * @property double $line_amount
 * @property double $vat
 * @property string $note
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class SaleLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sale_id', 'product_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by','stock_id'], 'integer'],
            [['qty', 'price', 'disc_amount', 'disc_percent', 'line_amount', 'vat'], 'number'],
            [['noneitem_name', 'note'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sale_id' => 'Sale ID',
            'product_id' => 'Product ID',
            'noneitem_name' => 'Noneitem Name',
            'qty' => 'Qty',
            'price' => 'Price',
            'disc_amount' => 'Disc Amount',
            'disc_percent' => 'Disc Percent',
            'line_amount' => 'Line Amount',
            'vat' => 'Vat',
            'note' => 'Note',
            'stock_id' => 'Stock ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
