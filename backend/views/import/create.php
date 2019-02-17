<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Import */

$this->title = 'นำเข้ารายการสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'นำเข้าสินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="import-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
