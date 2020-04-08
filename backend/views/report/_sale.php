<?php

use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;

$this->title = 'รายงานสรุปส่งออก';

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
                            'contentOptions' => ['style' => 'vertical-align: middle;font-weight: bold;'],
                            'value' => function ($data) {
                                return \backend\helpers\Month::getTypeById($data->month);
                            },
                            'group' => true,
                        ],
                        [
                            'attribute' => 'picking_date',
                            'contentOptions' => ['style' => 'vertical-align: middle;text-align: center;'],
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
                            'contentOptions' => ['style' => 'vertical-align: middle;text-align: center;'],
                            'label' => 'เลขที่ใบขน'
                        ],
//                        [
//                            'attribute' => 'transport_out_date',
//                            'contentOptions' => ['style' => 'vertical-align: middle'],
//                            'label' => 'วันที่',
//                            'value' => function ($data) {
//                                return date('d/m/Y', strtotime($data->transport_out_date));
//                            }
//                        ],
                        [
                            'attribute' => 'qty',
                            'label' => 'จำนวน',
                            'contentOptions' => ['style' => 'vertical-align: middle'],

                            'hAlign' => 'right',
                            'format' => ['decimal', 2],
                            'pageSummary' => true,
                            'pageSummaryFunc' => GridView::F_SUM
                        ],
                        [
                            'attribute' => 'unit_name',
                            'label' => 'หน่วย',
                            'contentOptions' => ['style' => 'vertical-align: middle'],
                        ],
//                        [
//                            'attribute' => 'product_group',
//                            'contentOptions' => ['style' => 'vertical-align: middle'],
//                            'label' => 'ประเภทสินค้า',
//                            'filterType' => GridView::FILTER_SELECT2,
//                            'filter' => ArrayHelper::map(\backend\models\Productcategory::find()->orderBy('name')->asArray()->all(), 'name', 'name'),
//                            'filterWidgetOptions' => [
//                                'pluginOptions' => ['allowClear' => true],
//                            ],
//                            'filterInputOptions' => ['placeholder' => 'เลือกประเภทสินค้า']
//                        ],
                        [
                            'contentOptions' => ['style' => 'vertical-align: middle'],
                            'label' => 'ประเภทสินค้า',
                            'value' => function ($data) {
                                return \backend\models\Queryinvoiceoutcategory::findCat($data->sale_no);
                            }
                        ],
                        [
                            'attribute' => 'sale_no',
                            'contentOptions' => ['style' => 'vertical-align: middle;text-align: center;'],
                            'label' => 'INV No.'
                        ],
                        [
                            'attribute' => 'rate',
                            'label' => 'อัตราแลกเปลี่ยน',
                            'contentOptions' => ['style' => 'vertical-align: middle'],
                            'value' => function ($data) {
                                return number_format($data->rate, 4);
                            }
                        ],
                        [
                            'label' => 'ราคาสินค้า(USD)',
                            'contentOptions' => ['style' => 'vertical-align: middle;text-align: right'],
                             'value' => function($data){
                                $amt = 0;
                                //$cur = \backend\models\Currency::findName($data->currency);
                                if($data->currency_name =='USD'){
                                    return $data->total_amount;
                                }else{
                                    return 0;
                                }
                            },
                            'hAlign' => 'right',
                            'format' => ['decimal', 2],
                            'pageSummary' => true,
                            'pageSummaryFunc' => GridView::F_SUM
                        ],
                        [
                            'label' => 'ราคาสินค้า(THB)',
                            'contentOptions' => ['style' => 'vertical-align: middle;text-align: right'],
                            'value' => function($data){
                                if($data->currency_name =='THB'){
                                    return $data->total_amount;
                                }else{
                                    return 0;
                                }
                                //$amt = 0;
                               // $cur = \backend\models\Currency::findName($data->currency);
                              // if($cur =='THB'){
                               //     return ($data->total_amount * $data->rate);
                               // }else{
                               //     return 0;
                               // }
                            },
                            'hAlign' => 'right',
                            'format' => ['decimal', 2],
                            'pageSummary' => true,
                            'pageSummaryFunc' => GridView::F_SUM
                        ],
                        //'name',
//                        [
//                            'attribute' => 'price',
//                            'contentOptions' => ['style' => 'vertical-align: middle'],
//                            'hAlign' => 'right',
//                            'format' => ['decimal', 2],
//                            'pageSummary' => true,
//                            'pageSummaryFunc' => GridView::F_SUM
//                        ],
                        [
                            'attribute' => 'country_name',
                            'label' => 'ขายไปยัง',

                            'contentOptions' => ['style' => 'vertical-align: middle'],
                        ],
                        [
                            'attribute' => 'customer_name',
                            'label' => 'ชื่อลูกค้า/ลูกหนี้',
                            'contentOptions' => ['style' => 'vertical-align: middle'],
                        ],
                        [
                            'attribute' => 'payment_status',
                            'label' => 'หลักฐานการโอนเงิน',
                            'contentOptions' => ['style' => 'vertical-align: middle'],
                        ],
                        [
                            'attribute' => 'note',
                            'label' => 'หมายเหตุ',
                            'contentOptions' => ['style' => 'vertical-align: middle'],
                        ]

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

