<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "journal_trans".
 *
 * @property int $id
 * @property int $journal_id
 * @property int $product_id
 * @property double $qty
 * @property int $journal_type_status
 * @property double $line_amount
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class JournalTrans extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'journal_trans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['journal_id', 'product_id', 'journal_type_status', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['qty', 'line_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'journal_id' => Yii::t('app', 'Journal ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'qty' => Yii::t('app', 'Qty'),
            'journal_type_status' => Yii::t('app', 'Journal Type Status'),
            'line_amount' => Yii::t('app', 'Line Amount'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
}
