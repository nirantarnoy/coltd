<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Currencyrate */

$this->title = 'Create Currencyrate';
$this->params['breadcrumbs'][] = ['label' => 'Currencyrates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currencyrate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
