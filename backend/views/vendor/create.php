<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Vendor */

$this->title = 'สร้างข้อมูลคู่ค้า';
$this->params['breadcrumbs'][] = ['label' => 'ข้อมูลคู่ค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vendor-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
