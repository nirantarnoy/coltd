<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CustumergroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'กลุ่มลูกค้า';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custumergroup-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="card">
        <div class="card-body">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Create Custumergroup', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    'name',
                    'description',
                    [
                        'attribute'=>'status',
                        'contentOptions' => ['style' => 'vertical-align: middle'],
                        'format' => 'html',
                        'value'=>function($data){
                            return $data->status === 1 ? '<div class="label label-success">Active</div>':'<div class="label label-red">Inactive</div>';
                        }
                    ],
                    //'updated_at',
                    //'created_by',
                    //'updated_by',

                    // ['class' => 'yii\grid\ActionColumn'],
                    [

                        'header' => '',
                        'headerOptions' => ['style' => 'width:160px;text-align:center;','class' => 'activity-view-link',],
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'text-align: center'],
                        'buttons' => [
                            'view' => function($url, $data, $index) {
                                $options = [
                                    'title' => Yii::t('yii', 'View'),
                                    'aria-label' => Yii::t('yii', 'View'),
                                    'data-pjax' => '0',
                                ];
                                return Html::a(
                                    '<span class="fa fa-eye btn btn-secondary"></span>', $url, $options);
                            },
                            'update' => function($url, $data, $index) {
                                $options = array_merge([
                                    'title' => Yii::t('yii', 'Update'),
                                    'aria-label' => Yii::t('yii', 'Update'),
                                    'data-pjax' => '0',
                                    'id'=>'modaledit',
                                ]);
                                return $data->status == 1? Html::a(
                                    '<span class="fa fa-edit btn btn-secondary"></span>', $url, [
                                    'id' => 'activity-view-link',
                                    //'data-toggle' => 'modal',
                                    // 'data-target' => '#modal',
                                    'data-id' => $index,
                                    'data-pjax' => '0',
                                    // 'style'=>['float'=>'rigth'],
                                ]):'';
                            },
                            'delete' => function($url, $data, $index) {
                                $options = array_merge([
                                    'title' => Yii::t('yii', 'Delete'),
                                    'aria-label' => Yii::t('yii', 'Delete'),
                                    //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    //'data-method' => 'post',
                                    //'data-pjax' => '0',
                                    'onclick'=>'recDelete($(this));'
                                ]);
                                return Html::a('<span class="fa fa-trash btn btn-secondary"></span>', 'javascript:void(0)', $options);
                            }
                        ]
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>

</div>
