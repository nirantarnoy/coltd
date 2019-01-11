<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale".
 *
 * @property int $id
 * @property string $sale_no
 * @property int $revise
 * @property int $require_date
 * @property int $customer_id
 * @property string $customer_ref
 * @property int $delvery_to
 * @property int $currency
 * @property int $sale_id
 * @property double $disc_amount
 * @property double $disc_percent
 * @property double $total_amount
 * @property int $quotation_id
 * @property string $note
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Sale extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sale_no','customer_id','currency'],'required'],
            [['revise','customer_id', 'delvery_to', 'currency', 'sale_id', 'quotation_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['disc_amount', 'disc_percent', 'total_amount'], 'number'],
            [['sale_no', 'customer_ref', 'note'], 'string', 'max' => 255],
            [['require_date'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sale_no' => 'เลขที่',
            'revise' => 'Revise',
            'require_date' => 'วันที่ต้องการ',
            'customer_id' => 'ลูกค้า',
            'customer_ref' => 'อ้างอิงลูกค้า',
            'delvery_to' => 'ที่อยู่จัดส่ง',
            'currency' => 'สกุลเงิน',
            'sale_id' => 'พนักงานขาย',
            'disc_amount' => 'Disc Amount',
            'disc_percent' => 'Disc Percent',
            'total_amount' => 'Total Amount',
            'quotation_id' => 'Quotation ID',
            'note' => 'บันทึกหมายเหตุ',
            'status' => 'สถานะ',
            'created_at' => 'วันที่',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
