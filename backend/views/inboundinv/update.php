<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Inboundinv */

$this->title = 'แก้ใขเลขที่: ' . $model->invoice_no;
$this->params['breadcrumbs'][] = ['label' => 'นำสินค้าเข้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->invoice_no, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="inboundinv-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelline'=> $modelline,
        'modeldoc' => $modeldoc,
        'modelpayment' => $modelpayment
    ]) ?>

</div>
