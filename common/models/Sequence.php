<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sequence".
 *
 * @property int $id
 * @property int $plant_id
 * @property int $module_id
 * @property string $prefix
 * @property string $symbol
 * @property int $use_year
 * @property int $use_month
 * @property int $use_day
 * @property int $minimum
 * @property int $maximum
 * @property int $currentnum
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Sequence extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sequence';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prefix','module_id'],'required'],
            [['prefix','module_id'],'unique'],
            [['plant_id', 'module_id', 'use_year', 'use_month', 'use_day', 'minimum', 'maximum', 'currentnum', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['prefix', 'symbol'], 'string', 'max' => 255],
            [['maximum'], 'compare', 'compareAttribute' => 'minimum', 'operator' => '>'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'plant_id' => Yii::t('app', 'ร้านค้า/หน่วยงาน'),
            'module_id' => Yii::t('app', 'ระบบงาน'),
            'prefix' => Yii::t('app', 'คำตั้งต้น'),
            'symbol' => Yii::t('app', 'สัญลักษ์'),
            'use_year' => Yii::t('app', 'ใช้งานปี'),
            'use_month' => Yii::t('app', 'ใช้งานเดือน'),
            'use_day' => Yii::t('app', 'ใช้งานวัน'),
            'minimum' => Yii::t('app', 'ต่ำสุด'),
            'maximum' => Yii::t('app', 'สูงสุด'),
            'currentnum' => Yii::t('app', 'ลำดับปัจจุบัน'),
            'status' => Yii::t('app', 'สถานะ'),
            'created_at' => Yii::t('app', 'สร้างเมื่อ'),
            'updated_at' => Yii::t('app', 'แก้ไขเมื่อ'),
            'created_by' => Yii::t('app', 'สร้างโดย'),
            'updated_by' => Yii::t('app', 'แก้ไขโดย'),
        ];
    }
}
