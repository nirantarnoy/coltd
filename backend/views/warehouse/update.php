<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Warehouse */

$this->title = Yii::t('app', 'แก้ไขคลังสินค้า: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'คลังสินค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="warehouse-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
