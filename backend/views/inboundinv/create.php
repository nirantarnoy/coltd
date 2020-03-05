<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Inboundinv */

$this->title = 'สร้างเลขทีนำเข้า';
$this->params['breadcrumbs'][] = ['label' => 'นำเข้าสินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inboundinv-create">

    <?= $this->render('_form', [
        'model' => $model,
        'runno' => $runno,
        'modeldoc' => null,
    ]) ?>

</div>
