<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Sale */

$this->title = 'สร้างรายการขาย';
$this->params['breadcrumbs'][] = ['label' => 'ขายสินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-create">

    <h1><i class="fa fa-shopping-basket text-warning"></i> <?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'runno' => $runno
    ]) ?>

</div>
