<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_stock".
 *
 * @property int $id
 * @property int $product_id
 * @property int $warehouse_id
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
 * @property double $usd_rate
 * @property double $thb_amount
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class ProductStock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_stock';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'warehouse_id', 'in_qty', 'out_qty', 'sequence', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['invoice_date', 'transport_in_date', 'permit_date', 'kno_in_date'], 'safe'],
            [['usd_rate', 'thb_amount'], 'number'],
            [['invoice_no', 'transport_in_no', 'permit_no', 'kno_no_in'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'รหัสสินค้า',
            'warehouse_id' => 'คลัง',
            'in_qty' => 'เข้า',
            'out_qty' => 'ออก',
            'invoice_no' => 'inv no.',
            'invoice_date' => 'inv date',
            'transport_in_no' => 'ใบขน',
            'transport_in_date' => 'วันที่',
            'sequence' => 'ลำดับ',
            'permit_no' => 'ใบอนุญาต',
            'permit_date' => 'วันที่',
            'kno_no_in' => 'กนอ.',
            'kno_in_date' => 'วันที',
            'usd_rate' => '$',
            'thb_amount' => 'THB',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
