<?php

namespace backend\models;

use Yii;
use yii\base\Model;

class Modelfile extends Model
{
    /**
     * @inheritdoc
     */
   public $file,$file_photo,$filecategory,$file_product,$file_vendor;
    public function rules()
    {
        return [
            [['file[]','file_photo[]','file_product','file_vendor'],'string'],
            [['filecategory'],'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file' => 'ไฟล์แนบ',
            'file_photo' => 'รูปงาน',
            'file_product' => 'ไฟล์แนบ',
            'file_vendor' => 'ไฟล์แนบ',
           'filecategory' => 'ชื่อกลุ่มไฟล์',
        ];
    }
}
