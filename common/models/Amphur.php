<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "amphur".
 *
 * @property int $AMPHUR_ID
 * @property string $AMPHUR_CODE
 * @property string $AMPHUR_NAME
 * @property string $POSTCODE
 * @property int $GEO_ID
 * @property int $PROVINCE_ID
 */
class Amphur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'amphur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AMPHUR_CODE', 'AMPHUR_NAME', 'POSTCODE'], 'required'],
            [['GEO_ID', 'PROVINCE_ID'], 'integer'],
            [['AMPHUR_CODE'], 'string', 'max' => 4],
            [['AMPHUR_NAME'], 'string', 'max' => 150],
            [['POSTCODE'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'AMPHUR_ID' => Yii::t('app', 'A M P H U R  I D'),
            'AMPHUR_CODE' => Yii::t('app', 'A M P H U R  C O D E'),
            'AMPHUR_NAME' => Yii::t('app', 'A M P H U R  N A M E'),
            'POSTCODE' => Yii::t('app', 'P O S T C O D E'),
            'GEO_ID' => Yii::t('app', 'G E O  I D'),
            'PROVINCE_ID' => Yii::t('app', 'P R O V I N C E  I D'),
        ];
    }
}
