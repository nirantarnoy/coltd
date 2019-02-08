<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $customer_group_id
 * @property int $payment_term
 * @property int $payment_type
 * @property int $delivery_type
 * @property int $sale_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'],'required'],
            [['customer_group_id','customer_type','currency_id', 'payment_term','card_id', 'payment_type', 'delivery_type', 'sale_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'description','code','first_name','last_name','email','mobile'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'รหัสลูกค้า'),
            'first_name' => Yii::t('app', 'ชื่อ'),
            'last_name' => Yii::t('app', 'นามสกุล'),
            'card_id' => Yii::t('app', 'เลขที่บัตรประชาชน'),
            'name' => Yii::t('app', 'ชื่อลูกค้า'),
            'description' => Yii::t('app', 'รายละเอียด'),
            'customer_group_id' => Yii::t('app', 'กลุ่มลูกค้า'),
            'customer_type' => Yii::t('app', 'ประเภทลูกค้า'),
            'payment_term' => Yii::t('app', 'วิธีชำระเงิน'),
            'payment_type' => Yii::t('app', 'Payment Type'),
            'delivery_type' => Yii::t('app', 'วิธีส่งมอบ'),
            'sale_id' => Yii::t('app', 'พนักงานขาย'),
            'currency_id' => 'สกุลเงิน',
            'mobile' => Yii::t('app', 'โทรศัพท์/มือถือ'),
            'status' => Yii::t('app', 'สถานะ'),
            'created_at' => Yii::t('app', 'สร้างเมื่อ'),
            'updated_at' => Yii::t('app', 'แก้ไขเมื่อ'),
            'created_by' => Yii::t('app', 'สร้างโดย'),
            'updated_by' => Yii::t('app', 'แก้ไขโดย'),
        ];
    }
}
