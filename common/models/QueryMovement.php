<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_movement".
 *
 * @property string $name
 * @property string $description
 * @property string $reference
 * @property int $reference_type_id
 * @property int $trans_type
 * @property int $status
 * @property string $journal_no
 * @property int $trans_date
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $product_id
 * @property double $qty
 * @property double $line_amount
 * @property int $from_wh
 * @property int $to_wh
 * @property int $from_loc
 * @property int $to_loc
 * @property int $from_lot
 * @property int $to_lot
 * @property int $diff_qty
 * @property int $id
 */
class QueryMovement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_movement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reference_type_id', 'trans_type', 'status', 'trans_date', 'created_at', 'updated_at', 'created_by', 'updated_by', 'product_id', 'from_wh', 'to_wh', 'from_loc', 'to_loc', 'from_lot', 'to_lot', 'diff_qty', 'id'], 'integer'],
            [['qty', 'line_amount'], 'number'],
            [['name', 'description', 'reference', 'journal_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'description' => 'Description',
            'reference' => 'Reference',
            'reference_type_id' => 'Reference Type ID',
            'trans_type' => 'Trans Type',
            'status' => 'Status',
            'journal_no' => 'Journal No',
            'trans_date' => 'Trans Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'product_id' => 'Product ID',
            'qty' => 'Qty',
            'line_amount' => 'Line Amount',
            'from_wh' => 'From Wh',
            'to_wh' => 'To Wh',
            'from_loc' => 'From Loc',
            'to_loc' => 'To Loc',
            'from_lot' => 'From Lot',
            'to_lot' => 'To Lot',
            'diff_qty' => 'Diff Qty',
            'id' => 'ID',
        ];
    }
}
