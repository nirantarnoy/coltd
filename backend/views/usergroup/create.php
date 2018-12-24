<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Usergroup */

$this->title = Yii::t('app', 'สร้างกลุ่มผู้ใช้งาน');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'กลุ่มผู้ใช้งาน'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usergroup-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
