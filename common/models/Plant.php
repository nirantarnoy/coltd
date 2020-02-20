<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plant".
 *
 * @property int $id
 * @property string $name
 * @property string $short_name
 * @property string $eng_name
 * @property string $description
 * @property string $tax_id
 * @property string $email
 * @property string $mobile
 * @property string $phone
 * @property string $website
 * @property string $facebook
 * @property string $line
 * @property string $logo
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Plant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name','permit_no','kno_no' ,'short_name', 'eng_name', 'description', 'tax_id', 'email', 'mobile', 'phone', 'website', 'facebook', 'line', 'logo'], 'string', 'max' => 255],
            [['kno_date'],'safe']
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'short_name' => Yii::t('app', 'Short Name'),
            'eng_name' => Yii::t('app', 'Eng Name'),
            'description' => Yii::t('app', 'Description'),
            'tax_id' => Yii::t('app', 'Tax ID'),
            'email' => Yii::t('app', 'Email'),
            'mobile' => Yii::t('app', 'Mobile'),
            'permit_no' => Yii::t('app', 'Permit No'),
            'phone' => Yii::t('app', 'Phone'),
            'website' => Yii::t('app', 'Website'),
            'facebook' => Yii::t('app', 'Facebook'),
            'line' => Yii::t('app', 'Line'),
            'logo' => Yii::t('app', 'Logo'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
}
