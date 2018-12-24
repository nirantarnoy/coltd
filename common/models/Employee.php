<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property int $gender_id
 * @property int $prefix
 * @property string $first_name
 * @property string $last_name
 * @property int $section_id
 * @property int $position_id
 * @property string $description
 * @property string $photo
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_code','first_name','last_name'],'required'],
            [['gender_id', 'prefix', 'section_id', 'position_id','user_id','salary_type', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['first_name', 'last_name', 'description', 'photo','emp_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'emp_code' => Yii::t('app', 'รหัสพนักงาน'),
            'gender_id' => Yii::t('app', 'เพศ'),
            'prefix' => Yii::t('app', 'คำนำหน้า'),
            'first_name' => Yii::t('app', 'ชื่อ'),
            'last_name' => Yii::t('app', 'นามสกุล'),
            'section_id' => Yii::t('app', 'แผนก'),
            'position_id' => Yii::t('app', 'ตำแหน่ง'),
            'description' => Yii::t('app', 'รายละเอียด'),
            'photo' => Yii::t('app', 'รูปภาพ'),
            'salary_type'=> Yii::t('app', 'ประเภทค่าจ้าง'),
            'status' => Yii::t('app', 'สถานะ'),
            'created_at' => Yii::t('app', 'สร้างเมื่อ'),
            'updated_at' => Yii::t('app', 'แก้ไขเมื่อ'),
            'created_by' => Yii::t('app', 'สร้างโดย'),
            'updated_by' => Yii::t('app', 'แก้ไขโดย'),
        ];
    }
}
