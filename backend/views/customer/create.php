<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Custumer */

$this->title = 'สร้างข้อมูลลูกค้า';
$this->params['breadcrumbs'][] = ['label' => 'ลูกค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custumer-create">

    <h1><i class="fa fa-users text-warning"></i> <?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'item_select'=>null,
        'bucket'=>null,
        'model_address'=>$model_address,
        'model_address_plant'=>$model_address_plant,
        'modeldoc'=>null,
    ]) ?>

</div>
