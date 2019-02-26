<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
date_default_timezone_set('Asia/Bangkok');

class Product extends \common\models\Product
{
  public function behaviors()
		{
		    return [
		        'timestampcdate'=>[
		            'class'=> \yii\behaviors\AttributeBehavior::className(),
		            'attributes'=>[
		            ActiveRecord::EVENT_BEFORE_INSERT=>'created_at',
		            ],
		            'value'=> time(),
		        ],
		        'timestampudate'=>[
		            'class'=> \yii\behaviors\AttributeBehavior::className(),
		            'attributes'=>[
		            ActiveRecord::EVENT_BEFORE_INSERT=>'updated_at',
		            ],
		          'value'=> time(),
		        ],
		        'timestampcby'=>[
		            'class'=> \yii\behaviors\AttributeBehavior::className(),
		            'attributes'=>[
		            ActiveRecord::EVENT_BEFORE_INSERT=>'created_by',
		            ],
		          'value'=> Yii::$app->user->identity->id,
		        ],
		         'timestamuby'=>[
		            'class'=> \yii\behaviors\AttributeBehavior::className(),
		            'attributes'=>[
		            ActiveRecord::EVENT_BEFORE_UPDATE=>'updated_by',
		            ],
		          'value'=> Yii::$app->user->identity->id,
		        ],
		        'timestampupdate'=>[
		            'class'=> \yii\behaviors\AttributeBehavior::className(),
		            'attributes'=>[
		            ActiveRecord::EVENT_BEFORE_UPDATE=>'updated_at',
		            ],
		            'value'=> time(),
		        ],
		    ];
		 }
		 public function findProductinfo($id){
           $model = Product::find()->where(['id'=>$id])->one();
           return count($model)>0?$model:null;
         }
         public function findCode($id){
          $model = Product::find()->where(['id'=>$id])->one();
          return count($model)>0?$model->product_code:'';
        }
    public function findName($id){
        $model = Product::find()->where(['id'=>$id])->one();
        return count($model)>0?$model->name:'';
    }
    public function findEng($id){
        $model = Product::find()->where(['id'=>$id])->one();
        return count($model)>0?$model->engname:'';
    }
    public function findGeo($id){
        $model = Product::find()->where(['id'=>$id])->one();
        $geo = '';
        if($model){
            $geo = \backend\models\Productcategory::findGeo($model->category_id);
        }

        return $geo;
    }
    public function findImg($id){
        $model = \backend\models\Productimage::find()->where(['product_id'=>$id])->one();
        return count($model)>0?$model->name:'';
    }

        public function findProductcatname($id){
            $model = Product::find()->where(['id'=>$id])->one();
            $catname = '';
            if($model){
                $catname = \backend\models\Productcategory::findGroupname($model->category_id);
            }

            return $catname;
        }

}
