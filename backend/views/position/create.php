<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Position */

$this->title = Yii::t('app', 'สร้างตำแหน่ง');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ตำแหน่ง'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
