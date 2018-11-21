<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AddressbookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Addressbooks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="addressbook-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Addressbook', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'address_type_id',
            'party_type_id',
            'party_id',
            'address',
            //'street',
            //'district_id',
            //'city_id',
            //'province_id',
            //'zipcode',
            //'is_primary',
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
