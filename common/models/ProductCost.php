<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_cost".
 *
 * @property int $id
 * @property int $product_id
 * @property int $trans_date
 * @property string $transport_in_no
 * @property string $transport_in_date
 * @property string $permit_no
 * @property string $permit_date
 * @property string $excise_no
 * @property string $excise_date
 * @property double $cost
 * @property string $note
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class ProductCost extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_cost';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'trans_date', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['transport_in_date', 'permit_date', 'excise_date'], 'safe'],
            [['cost'], 'number'],
            [['transport_in_no', 'permit_no', 'excise_no', 'note'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'trans_date' => 'Trans Date',
            'transport_in_no' => 'Transport In No',
            'transport_in_date' => 'Transport In Date',
            'permit_no' => 'Permit No',
            'permit_date' => 'Permit Date',
            'excise_no' => 'Excise No',
            'excise_date' => 'Excise Date',
            'cost' => 'Cost',
            'note' => 'Note',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
