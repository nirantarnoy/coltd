<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "district".
 *
 * @property int $DISTRICT_ID
 * @property string $DISTRICT_CODE
 * @property string $DISTRICT_NAME
 * @property int $AMPHUR_ID
 * @property int $PROVINCE_ID
 * @property int $GEO_ID
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'district';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DISTRICT_CODE', 'DISTRICT_NAME'], 'required'],
            [['AMPHUR_ID', 'PROVINCE_ID', 'GEO_ID'], 'integer'],
            [['DISTRICT_CODE'], 'string', 'max' => 6],
            [['DISTRICT_NAME'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'DISTRICT_ID' => Yii::t('app', 'D I S T R I C T  I D'),
            'DISTRICT_CODE' => Yii::t('app', 'D I S T R I C T  C O D E'),
            'DISTRICT_NAME' => Yii::t('app', 'D I S T R I C T  N A M E'),
            'AMPHUR_ID' => Yii::t('app', 'A M P H U R  I D'),
            'PROVINCE_ID' => Yii::t('app', 'P R O V I N C E  I D'),
            'GEO_ID' => Yii::t('app', 'G E O  I D'),
        ];
    }
}
