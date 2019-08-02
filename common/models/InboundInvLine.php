<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "inbound_inv_line".
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $product_id
 * @property int $warehouse_id
 * @property int $line_qty
 * @property string $invoice_no
 * @property string $invoice_date
 * @property string $transport_in_no
 * @property string $transport_in_date
 * @property int $sequence
 * @property string $permit_no
 * @property string $permit_date
 * @property string $kno_no_in
 * @property string $kno_in_date
 * @property double $line_price
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class InboundInvLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inbound_inv_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoice_id', 'product_id', 'warehouse_id', 'line_qty', 'sequence', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['invoice_date', 'transport_in_date', 'permit_date', 'kno_in_date'], 'safe'],
            [['line_price'], 'number'],
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
            'invoice_id' => 'Invoice ID',
            'product_id' => 'Product ID',
            'warehouse_id' => 'Warehouse ID',
            'line_qty' => 'Line Qty',
            'invoice_no' => 'Invoice No',
            'invoice_date' => 'Invoice Date',
            'transport_in_no' => 'Transport In No',
            'transport_in_date' => 'Transport In Date',
            'sequence' => 'Sequence',
            'permit_no' => 'Permit No',
            'permit_date' => 'Permit Date',
            'kno_no_in' => 'Kno No In',
            'kno_in_date' => 'Kno In Date',
            'line_price' => 'Line Price',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
