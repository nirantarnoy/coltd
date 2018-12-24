<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Location */

$this->title = Yii::t('app', 'สร้างล๊อกจัดเก็บ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ล๊อกจัดเก็บ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="location-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
