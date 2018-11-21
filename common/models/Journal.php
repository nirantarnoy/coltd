<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "journal".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $reference
 * @property int $reference_type_id
 * @property int $trans_type
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Journal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'journal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reference_type_id', 'trans_type', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'description', 'reference'], 'string', 'max' => 255],
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
            'description' => Yii::t('app', 'Description'),
            'reference' => Yii::t('app', 'Reference'),
            'reference_type_id' => Yii::t('app', 'Reference Type ID'),
            'trans_type' => Yii::t('app', 'Trans Type'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
}
