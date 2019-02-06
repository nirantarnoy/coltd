<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "picking_line".
 *
 * @property int $id
 * @property int $picking_id
 * @property int $product_id
 * @property double $qty
 * @property int $site_id
 * @property int $warehouse_id
 * @property int $location_id
 * @property int $lot_id
 * @property string $note
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class PickingLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'picking_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['picking_id', 'product_id', 'site_id', 'warehouse_id', 'location_id', 'lot_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['qty'], 'number'],
            [['note'], 'string', 'max' => 255],
            [['permit_no','excise_no','transport_in_no'],'string'],
            [['permit_date','excise_date','transport_in_date'],'date']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'picking_id' => 'Picking ID',
            'product_id' => 'Product ID',
            'qty' => 'Qty',
            'site_id' => 'Site ID',
            'warehouse_id' => 'Warehouse ID',
            'location_id' => 'Location ID',
            'lot_id' => 'Lot ID',
            'note' => 'Note',
            'status' => 'Status',
            'permit_no' => 'ใบอนุญาต',
            'excise_no' => 'สรรพสามิต',
            'transport_in_no' => 'ใบขนเข้า',
            'permit_date' => 'วันที่',
            'excise_date' => 'วันที่',
            'transport_in_date' => 'วันที่',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
