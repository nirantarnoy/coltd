<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Position */

$this->title = Yii::t('app', 'แก้ไขตำแหน่ง: ' . $model->name, [
    'nameAttribute' => '' . $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ตำแหน่ง'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'แก้ไข');
?>
<div class="position-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
