<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Currencyrate */

$this->title = 'แก้ไขอัตราแลกเปลี่ยน: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'อัตราแลกเปลี่ยน', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="currencyrate-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
