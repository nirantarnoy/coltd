<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Import */

$this->title = 'แก้ไข: ' . $model->invoice_no;
$this->params['breadcrumbs'][] = ['label' => 'นำเข้าสินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="import-update">
    <?= $this->render('_form', [
        'model' => $model,
        'modelfile' => $modelfile,
        'modelline'=> $modelline,
    ]) ?>

</div>
