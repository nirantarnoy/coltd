<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "qry_ar_summary".
 *
 * @property int $id
 * @property string|null $sale_no
 * @property float|null $total_amount
 * @property float|null $amount
 * @property int|null $customer_id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $require_date
 */
class QryArSummary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qry_ar_summary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'require_date'], 'integer'],
            [['total_amount', 'amount'], 'number'],
            [['sale_no', 'name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sale_no' => 'Sale No',
            'total_amount' => 'Total Amount',
            'amount' => 'Amount',
            'customer_id' => 'Customer ID',
            'name' => 'Name',
            'description' => 'Description',
            'require_date' => 'Require Date',
        ];
    }
}
