<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "picking".
 *
 * @property int $id
 * @property string $picking_no
 * @property int $trans_date
 * @property int $sale_id
 * @property string $note
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Picking extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'picking';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_date', 'sale_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['picking_no', 'note'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'picking_no' => 'Picking No',
            'trans_date' => 'Trans Date',
            'sale_id' => 'Sale ID',
            'note' => 'Note',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
