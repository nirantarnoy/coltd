<?php
namespace common\rbac;

use backend\models\User;
use yii\rbac\Rule;

class DeleteRecordRule extends Rule
{
    public $name = 'canDelete';

    public function execute($user_id, $item, $params)
    {

       $roles = User::findRoleByUser($user_id);

       // if(count($roles)>0 && $roles[0]=='System Administrator'){
        if(1>0){
                return 1;
       }else{
           return 0;
       }
    }
}
?>