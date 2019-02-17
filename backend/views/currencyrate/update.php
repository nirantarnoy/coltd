<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Currencyrate */

$this->title = 'Update Currencyrate: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Currencyrates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="currencyrate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
