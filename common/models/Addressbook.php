<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "addressbook".
 *
 * @property int $id
 * @property int $address_type_id
 * @property int $party_type_id
 * @property int $party_id
 * @property string $address
 * @property string $street
 * @property int $district_id
 * @property int $city_id
 * @property int $province_id
 * @property int $zipcode
 * @property int $is_primary
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Addressbook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'addressbook';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address_type_id', 'party_type_id', 'party_id', 'district_id', 'city_id', 'province_id', 'zipcode', 'is_primary', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['address', 'street'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'address_type_id' => Yii::t('app', 'Address Type ID'),
            'party_type_id' => Yii::t('app', 'Party Type ID'),
            'party_id' => Yii::t('app', 'Party ID'),
            'address' => Yii::t('app', 'Address'),
            'street' => Yii::t('app', 'Street'),
            'district_id' => Yii::t('app', 'District ID'),
            'city_id' => Yii::t('app', 'City ID'),
            'province_id' => Yii::t('app', 'Province ID'),
            'zipcode' => Yii::t('app', 'Zipcode'),
            'is_primary' => Yii::t('app', 'Is Primary'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
}
