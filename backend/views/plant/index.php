<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use lavrentiev\widgets\toastr\Notification;
use yii2mod\alert\Alert;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PlantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'บริษัท');
$this->params['breadcrumbs'][] = $this->title;
?>
<ol class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="#">Library</a></li>
  <li class="active">Data</li>
</ol>
<div class="plant-index">
     

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'สร้างข้อมูลบริษัท'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'short_name',
            'eng_name',
            'description',
            //'tax_id',
            //'email:email',
            //'mobile',
            //'phone',
            //'website',
            //'facebook',
            //'line',
            //'logo',
            //'status',
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
