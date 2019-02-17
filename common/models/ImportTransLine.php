<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "import_trans_line".
 *
 * @property int $id
 * @property int $import_id
 * @property int $product_id
 * @property double $price_pack1
 * @property double $price_pack2
 * @property int $qty
 * @property int $product_packing
 * @property double $price_per
 * @property double $total_price
 * @property int $total_qty
 * @property int $weight_litre
 * @property double $netweight
 * @property double $grossweight
 * @property string $transport_in_no
 * @property int $line_num
 * @property string $position
 * @property string $origin
 * @property string $excise_no
 * @property string $excise_date
 * @property string $kno
 * @property string $kno_date
 * @property string $permit_no
 * @property string $permit_date
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class ImportTransLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'import_trans_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['import_id', 'product_id', 'qty', 'product_packing', 'total_qty', 'weight_litre', 'line_num', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['price_pack1', 'price_pack2', 'price_per', 'total_price', 'netweight', 'grossweight'], 'number'],
            [['excise_date', 'kno_date', 'permit_date'], 'safe'],
            [['transport_in_no', 'position', 'origin', 'excise_no', 'kno', 'permit_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'import_id' => 'Import ID',
            'product_id' => 'Product ID',
            'price_pack1' => 'Price Pack1',
            'price_pack2' => 'Price Pack2',
            'qty' => 'Qty',
            'product_packing' => 'Product Packing',
            'price_per' => 'Price Per',
            'total_price' => 'Total Price',
            'total_qty' => 'Total Qty',
            'weight_litre' => 'Weight Litre',
            'netweight' => 'Netweight',
            'grossweight' => 'Grossweight',
            'transport_in_no' => 'Transport In No',
            'line_num' => 'Line Num',
            'position' => 'Position',
            'origin' => 'Origin',
            'excise_no' => 'Excise No',
            'excise_date' => 'Excise Date',
            'kno' => 'Kno',
            'kno_date' => 'Kno Date',
            'permit_no' => 'Permit No',
            'permit_date' => 'Permit Date',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
