<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Currency */

$this->title = 'แก้ไขสกุลเงิน: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'สกุลเงิน', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="currency-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
