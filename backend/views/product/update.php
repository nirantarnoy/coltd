<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->title = Yii::t('app', 'แก้ไขรหัสสินค้า: {nameAttribute}', [
    'nameAttribute' => $model->product_code,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'รหัสสินค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_code, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="product-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
