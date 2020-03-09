<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "query_invoice_category".
 *
 * @property string $docin_no
 * @property string $name
 */
class QueryInvoiceCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'query_invoice_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['docin_no', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'docin_no' => 'Docin No',
            'name' => 'Name',
        ];
    }
}
