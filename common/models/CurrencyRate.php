<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "currency_rate".
 *
 * @property int $id
 * @property string $name
 * @property int $from_currency
 * @property int $to_integer
 * @property double $rate
 * @property double $rate_factor
 * @property string $from_date
 * @property string $to_date
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class CurrencyRate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency_rate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from_currency', 'to_integer', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['rate', 'rate_factor'], 'number'],
            [['from_date', 'to_date'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'from_currency' => 'From Currency',
            'to_integer' => 'To Integer',
            'rate' => 'Rate',
            'rate_factor' => 'Rate Factor',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
