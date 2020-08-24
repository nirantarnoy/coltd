<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "qry_ap_summary".
 *
 * @property int $id
 * @property string|null $invoice_no
 * @property string|null $invoice_date
 * @property float|null $total_amount
 * @property string|null $name
 * @property string|null $description
 * @property float|null $amount
 */
class QryApSummary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qry_ap_summary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['invoice_date'], 'safe'],
            [['total_amount', 'amount'], 'number'],
            [['invoice_no', 'name', 'description'], 'string', 'max' => 255],
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
            'invoice_date' => 'Invoice Date',
            'total_amount' => 'Total Amount',
            'name' => 'Name',
            'description' => 'Description',
            'amount' => 'Amount',
        ];
    }
}
