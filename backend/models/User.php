<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

date_default_timezone_set('Asia/Bangkok');

class User extends \common\models\User
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
		        'timestampupdate'=>[
		            'class'=> \yii\behaviors\AttributeBehavior::className(),
		            'attributes'=>[
		            ActiveRecord::EVENT_BEFORE_UPDATE=>'updated_at',
		            ],
		            'value'=> time(),
		        ],
		    ];
		 }
    public function findUserType($id){
      $model = \backend\models\Suplier::find()->where(['user_id'=>$id])->all();
      return count($model)>0?"suplier":"user";
    }
    public function getAllRoles(){
        $auth = $auth = \Yii::$app->authManager;
        return ArrayHelper::map($auth->getRoles(),'name','name');

    }
    public function getUserinfo($id){
        $model = User::find()->where(['id'=>$id])->one();
        return count($model)>0?$model:null;

    }
    public function findName($id){
        $model = User::find()->where(['id'=>$id])->one();
        return count($model)>0?$model->username:'';

    }
    public function getRoleByUser(){
        $auth = Yii::$app->authManager;
        $rolesUser = $auth->getRolesByUser($this->id);
        $roleItems = $this->getAllRoles();
        $roleSelect=[];

        foreach ($roleItems as $key => $roleName) {
            foreach ($rolesUser as $role) {
                if($key==$role->name){
                    $roleSelect[$key]=$roleName;
                }
            }
        }
        $this->roles = $roleSelect;
    }
    public function assignment(){
        $auth = \Yii::$app->authManager;
        $roleUser = $auth->getRolesByUser($this->id);
        $auth->revokeAll($this->id);
        foreach ($this->roles as $key => $roleName) {
            $auth->assign($auth->getRole($roleName),$this->id);
        }
    }

    //// Add


    public function findRoleByUser($id){
        $auth = Yii::$app->authManager;
        $roleUser = $auth->getRolesByUser($id);
        $roleSelect=[];

        foreach ($roleUser as $roleName) {
            array_push($roleSelect,$roleName->name);
        }
        return $roleSelect;
    }

}
