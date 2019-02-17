<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Currencyrate */

$this->title = 'สร้างอัตราแลกเปลี่ยน';
$this->params['breadcrumbs'][] = ['label' => 'อัตราแลกเปลี่ยน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currencyrate-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
