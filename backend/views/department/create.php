<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Department */

$this->title = Yii::t('app', 'สร้างฝ่าย');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ข้อมูลฝ่าย'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
