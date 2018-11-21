<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Addressbook */

$this->title = 'Create Addressbook';
$this->params['breadcrumbs'][] = ['label' => 'Addressbooks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="addressbook-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
