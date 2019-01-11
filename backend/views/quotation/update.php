<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Quotation */

$this->title = 'แก้ใขใบเสนอราคา: ' . $model->quotation_no;
$this->params['breadcrumbs'][] = ['label' => 'ใบเสนอราคา', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->quotation_no, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>
<div class="quotation-update">

    <h1><i class="fa fa-edit text-warning"></i> <?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelline' => $modelline,
    ]) ?>

</div>
