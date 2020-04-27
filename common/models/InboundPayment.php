<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "inbound_payment".
 *
 * @property int $id
 * @property string $trans_date
 * @property int $inbound_id
 * @property double $amount
 * @property string $payment_by
 * @property string $note
 * @property int $status
 * @property string $slip
 * @property string $trans_time
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class InboundPayment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inbound_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_date', 'trans_time'], 'safe'],
            [['inbound_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['payment_by', 'note', 'slip'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trans_date' => 'Trans Date',
            'inbound_id' => 'Inbound ID',
            'amount' => 'Amount',
            'payment_by' => 'Payment By',
            'note' => 'Note',
            'status' => 'Status',
            'slip' => 'Slip',
            'trans_time' => 'Trans Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
