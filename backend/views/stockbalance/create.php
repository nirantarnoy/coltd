<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Stockbalance */

$this->title = 'Create Stockbalance';
$this->params['breadcrumbs'][] = ['label' => 'Stockbalances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stockbalance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
