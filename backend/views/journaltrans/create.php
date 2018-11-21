<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Journaltrans */

$this->title = 'Create Journaltrans';
$this->params['breadcrumbs'][] = ['label' => 'Journaltrans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journaltrans-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
