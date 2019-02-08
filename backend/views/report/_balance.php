<?php
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;

$this->title = 'รายงานสินค้าคงเหลือ';

?>
<div class="x_panel">
    <div class="x_title">
        <h3><i class="fa fa-bar-chart-o"></i> <?=$this->title?> <small></small></h3>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="row">
            <div class="col-lg-12">
                <?php

                echo ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        // 'id',
                        [
                            'attribute' => 'journal_date',
                            'format' => 'raw',
                            'value' => function($data){
                                return Yii::$app->formatter->asDate($data->journal_date, 'php:d/m/Y');
                            },
                            'filter'=> DatePicker::widget([
                                'model'=> $searchModel,
                                'attribute' => 'journal_date',
                                'clientOptions' => [
                                    'autoclose'=>true,
                                    'format'=>'yyyy/mm/dd'
                                ]
                            ])
                        ],
                        'engname',
                        'name',
                        'volumn',
                        'unit_factor',
                        'volumn_content',
                        [
                            'attribute' => 'stock_in',
                            // 'format' => 'currency',
                            'format' => 'integer',

                        ],
                        [
                            'attribute' => 'stock_out',
                            'contentOptions' => [
                                'style'=>'text-align: right'
                            ],
                            // 'format' => 'currency',
                            'format' => 'integer',
                            'hAlign'=>'right',
                            'pageSummary' => true,
                        ],
                        [
                            'attribute' => 'all_qty',
                            'label' => 'จำนวนคงเหลือ',
                            'contentOptions' => [
                                'style'=>'text-align: right'
                            ],
                            // 'format' => 'currency',
                            'format' => 'integer',
                            'hAlign'=>'right',
                            'pageSummary' => true,
                        ],


                    ],
                    'pjax' => true,
                    'bordered' => true,
                    'striped' => false,
                    'condensed' => false,
                    'responsive' => true,
                    'hover' => true,
                    //'floatHeader' => true,
                    // 'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
                    'showPageSummary' => true,
                ]);
                ?>
            </div>
        </div>
        <br>
        <div class="panel panel-body">
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'emptyCell'=>'-',
                'layout'=>'{items}{summary}{pager}',
                'summary' => "แสดง {begin} - {end} ของทั้งหมด {totalCount} รายการ",
                'showOnEmpty'=>true,
                //'showPageSummary'=>true,
                'tableOptions' => ['class' => 'table table-hover'],
                'emptyText' => '<br/><div style="color: red;align: center;"> <b>ไม่พบรายการไดๆ</b></div>',
                'columns' => [
                  //  ['class' => 'yii\grid\SerialColumn'],

                    // 'id',
                    [
                        'attribute' => 'journal_date',
                        'format' => 'raw',
                        'value' => function($data){
                            return Yii::$app->formatter->asDate($data->journal_date, 'php:d/m/Y');
                        },
                        'filter'=> DatePicker::widget([
                            'model'=> $searchModel,
                            'attribute' => 'journal_date',
                            'clientOptions' => [
                                'autoclose'=>true,
                                'format'=>'yyyy/mm/dd'
                            ]
                        ])
                    ],
                    'engname',
                    'name',
                    'volumn',
                    'unit_factor',
                    'volumn_content',
                    [
                        'attribute' => 'stock_in',
                        // 'format' => 'currency',
                        'format' => 'integer',

                    ],
                    [
                        'attribute' => 'stock_out',
                        'contentOptions' => [
                               'style'=>'text-align: right'
                            ],
                        // 'format' => 'currency',
                        'format' => 'integer',
                        'hAlign'=>'right',
                         'pageSummary' => true,
                    ],
                    [
                        'attribute' => 'all_qty',
                        'label' => 'จำนวนคงเหลือ',
                        'contentOptions' => [
                            'style'=>'text-align: right'
                        ],
                        // 'format' => 'currency',
                        'format' => 'integer',
                        'hAlign'=>'right',
                        'pageSummary' => true,
                    ],


                ],
                'pjax' => true,
                'bordered' => true,
                'striped' => false,
                'condensed' => false,
                'responsive' => true,
                'hover' => true,
                //'floatHeader' => true,
               // 'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
                'showPageSummary' => true,
               // 'showFooter' => true,
            ]); ?>
        </div>
        </div>
        <!--        <div class="row">-->
        <!--            <div class="col-lg-12">-->
        <!--                <div class="pull-right">-->
        <!--                    <div class="btn btn-info"><i class="fa fa-print"></i> พิมพ์</div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
    </div>
</div>

