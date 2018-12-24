<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('app', 'สร้างผู้ใช้งาน');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ผู้ใช้งาน'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
