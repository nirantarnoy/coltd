<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale_invoice".
 *
 * @property int $id
 * @property string $invoice_no
 * @property int $sale_id
 * @property double $disc_amount
 * @property double $disc_percent
 * @property double $total_amount
 * @property string $note
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class SaleInvoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sale_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['disc_amount', 'disc_percent', 'total_amount'], 'number'],
            [['invoice_no', 'note'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_no' => 'Invoice No',
            'sale_id' => 'Sale ID',
            'disc_amount' => 'Disc Amount',
            'disc_percent' => 'Disc Percent',
            'total_amount' => 'Total Amount',
            'note' => 'Note',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
