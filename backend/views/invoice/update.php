<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Invoice */

$this->title = 'แก้ไข: ' . $model->invoice_no;
$this->params['breadcrumbs'][] = ['label' => 'ใบเก็บเงิน', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->invoice_no, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="invoice-update">

    <h1><i class="fa fa-edit text-warning"></i> <?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
