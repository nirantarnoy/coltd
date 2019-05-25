<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Productstock */

$this->title = 'Create Productstock';
$this->params['breadcrumbs'][] = ['label' => 'Productstocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="productstock-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
