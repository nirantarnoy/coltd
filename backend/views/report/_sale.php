<?php

use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;

$this->title = 'รายงานยอดขาย';

?>
<div class="x_panel">
    <div class="x_title">
        <h3><i class="fa fa-bar-chart-o"></i> <?= $this->title ?>
            <small></small>
        </h3>

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
                            'attribute' => 'month',
                            'value' => function ($data) {
                                return \backend\helpers\Month::getTypeById($data->month);
                            },
                            'group' => true,
                        ],
                        [
                            'attribute' => 'picking_date',
//                            'value' => function($data){
//                                return date('d/m/Y',$data->trans_date);
//                            }
//                            'format' => 'raw',
//                            'value' => function($data){
//                                return Yii::$app->formatter->asDate($data->journal_date, 'php:d/m/Y');
//                            },
//                            'filter'=> DatePicker::widget([
//                                'model'=> $searchModel,
//                                'attribute' => 'journal_date',
//                                'clientOptions' => [
//                                    'autoclose'=>true,
//                                    'format'=>'yyyy/mm/dd'
//                                ]
//                            ])
                        ],
                        'transport_out_no',
                        'qty',
                        'unit_name',
                        'product_group',
                        //'name',
                        'price',
                        'country_name',
                        'customer_name',

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
                    'emptyCell' => '-',
                    'layout' => '{items}{summary}{pager}',
                    'summary' => "แสดง {begin} - {end} ของทั้งหมด {totalCount} รายการ",
                    'showOnEmpty' => true,
                    //'showPageSummary'=>true,
                    'tableOptions' => ['class' => 'table table-hover'],
                    'emptyText' => '<br/><div style="color: red;align: center;"> <b>ไม่พบรายการไดๆ</b></div>',
                    'toggleDataContainer' => ['class' => 'btn-group mr-2'],
                    'columns' => [
                        ['class' => 'kartik\grid\SerialColumn'],
                        [
                            'attribute' => 'month',
                            'value' => function ($data) {
                                return \backend\helpers\Month::getTypeById($data->month);
                            },
                            'group' => true,
                        ],
                        [
                            'attribute' => 'picking_date',
                            'hAlign' => 'left',
                            'format' => 'raw',
                            'filterType' => GridView::FILTER_DATE_RANGE,
                            'filterWidgetOptions' => ([
                                'attribute' => 'only_date',
                                'presetDropdown' => true,
                                'convertFormat' => false,
                                'pluginOptions' => [
                                    'separator' => ' - ',
                                    'format' => 'YYYY/MM/DD',
                                    'locale' => [
                                        'format' => 'YYYY/MM/DD'
                                    ],
                                ],
                                'pluginEvents' => [
                                    "apply.daterangepicker" => "function() { apply_filter('only_date') }",
                                ],
                            ])


//                            'value' => function($data){
//                                return Yii::$app->formatter->asDate($data->trans_date, 'php:d/m/Y');
//                            },
//                            'filter'=> DatePicker::widget([
//                                'model'=> $searchModel,
//                                'attribute' => 'picking_date',
//                                'clientOptions' => [
//                                    'autoclose'=>true,
//                                    'format'=>'yyyy/mm/dd'
//                                ]
//                            ]),

                        ],
                        [
                            'attribute' => 'transport_out_no',
                            'label' => 'เลขที่ใบขน'
                        ],
                        [
                            'attribute' => 'transport_out_date',
                            'label' => 'วันที่',
                            'value'=>function($data){
                               return date('d/m/Y',strtotime($data->transport_out_date));
                            }
                        ],
                        [
                            'attribute' => 'qty',
                            'hAlign' => 'right',
                            'format' => ['decimal', 2],
                            'pageSummary' => true,
                            'pageSummaryFunc' => GridView::F_SUM
                        ],
                        'unit_name',
                        [
                            'attribute' => 'product_group',
                            'label' => 'ประเภทสินค้า',
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => ArrayHelper::map(\backend\models\Productcategory::find()->orderBy('name')->asArray()->all(), 'name', 'name'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'เลือกประเภทสินค้า']
                        ],
                        //'name',
                        [
                            'attribute' => 'price',
                            'hAlign' => 'right',
                            'format' => ['decimal', 2],
                            'pageSummary' => true,
                            'pageSummaryFunc' => GridView::F_SUM
                        ],
                        'country_name',
                        'customer_name',

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

