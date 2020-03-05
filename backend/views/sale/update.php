<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Sale */

$this->title = 'แก้ไข Invoice: ' . $model->sale_no;
$this->params['breadcrumbs'][] = ['label' => 'Invoice', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sale_no, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="sale-update">

    <h1><i class="fa fa-edit text-warning"></i> <?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelline' => $modelline,
        'modelpick' => $modelpick,
        'modelpickline' => $modelpickline,
        'modelpayment' => $modelpayment,
        'modeldoc'=>$modeldoc,
    ]) ?>

</div>
