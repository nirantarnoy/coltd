<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Picking */

$this->title = 'Create Picking';
$this->params['breadcrumbs'][] = ['label' => 'Pickings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="picking-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
