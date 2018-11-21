<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Usergroup */

$this->title = 'Update Usergroup: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Usergroups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="usergroup-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
