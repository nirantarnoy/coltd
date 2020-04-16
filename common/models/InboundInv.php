<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "inbound_inv".
 *
 * @property int $id
 * @property string $invoice_no
 * @property string $invoice_date
 * @property int $delivery_term
 * @property string $sold_to
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class InboundInv extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inbound_inv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoice_no','supplier_id','currency'],'required'],
            [['invoice_date'], 'safe'],
            [['delivery_term', 'created_at','currency_id','supplier_id', 'updated_at','currency_id', 'created_by', 'updated_by'], 'integer'],
            [['status'],'safe'],
            [['invoice_no', 'sold_to','customer_ref','docin_no'], 'string', 'max' => 255],
            [['currency_rate'],'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_no' => 'เลขที่',
            'invoice_date' => 'วันที่',
            'delivery_term' => 'Delivery Term',
            'sold_to' => 'Sold To',
            'status' => 'สถานะ',
            'customer_ref' => 'เลขที่อ้างอิงลูกค้า',
            'docin_no' =>'เลขที่นำเข้า',
            'currency_id' =>'สกุลเงิน',
            'currency_rate'=>'แลกเปลี่ยน',
            'created_at' => Yii::t('app', 'สร้างเมื่อ'),
            'updated_at' => Yii::t('app', 'แก้ไขเมื่อ'),
            'created_by' => Yii::t('app', 'สร้างโดย'),
            'updated_by' => Yii::t('app', 'แก้ไขโดย'),
        ];
    }
}
