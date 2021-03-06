<?php

use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;

$this->title = 'รายงานสรุปนำเข้า';

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
                        'layout' => '{items}{summary} <br> {pager}',
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
                                'attribute' => 'invoice_date',
                                'contentOptions' => ['style' => 'vertical-align: middle;text-align: center;'],
                                'hAlign' => 'left',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return date('d/m/Y', strtotime($data->invoice_date));
                                },
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
                                'attribute' => 'transport_in_no',
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
                                'attribute' => 'line_qty',
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
                            [
                                'contentOptions' => ['style' => 'vertical-align: middle'],
                                'label' => 'ประเภทสินค้า',
                                'value' => function ($data) {
                                    return \backend\models\Queryinvoicecategory::findCat($data->docin_no);
                                }
                            ],
//                        [
//                            'attribute' => 'category_name',
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
                                'attribute' => 'invoice_no',
                                'contentOptions' => ['style' => 'vertical-align: middle;text-align: center;'],
                                'label' => 'INV No.'
                            ],
                            [
                                'attribute' => 'currency_rate',
                                'label' => 'อัตราแลกเปลี่ยน',
                                'contentOptions' => ['style' => 'vertical-align: middle'],
                                'value' => function ($data) {
                                    return number_format($data->currency_rate, 4);
                                }
                            ],
                            [
                                'label' => 'ราคาสินค้า(USD)',
                                'contentOptions' => ['style' => 'vertical-align: middle;text-align: right'],
                                'value' => function ($data) {
                                    $amt = 0;
                                    //$cur = \backend\models\Currency::findName($data->currency);
                                    if ($data->currency_name == 'USD') {
                                        return $data->line_price;
                                    } else {
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
                                'value' => function ($data) {
                                    $amt = 0;
                                    // $cur = \backend\models\Currency::findName($data->currency);
                                    // if($cur =='THB'){
                                    return ($data->line_price * $data->currency_rate);
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
                                'attribute' => 'name',
                                'label' => 'ชื่อเจ้าหนี้',
                                'contentOptions' => ['style' => 'vertical-align: middle'],
                            ],
                            [
                                //'attribute' => 'payment_status',
                                'label' => 'หลักฐานการโอนเงิน',
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'vertical-align: middle'],
                                'value' => function ($data) {

                                    $html = "<div class='btn btn-info' data-var='".$data->invoice_no."' onclick='showPay($(this))'>ดูเอกสาร</div>";
                                    return $html;
                                }
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

    <div id="payModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="row">
                        <div class="col-sm-6">
                            <h3>ประวัติการชำระเงิน</h3>
                        </div>
                    </div>

                </div>
                <div class="modal-body" style="white-space:nowrap;overflow-y: auto">
                    <table class="table table-list">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>วันที่</th>
                            <th>จำนวน</th>
                            <th>Note</th>
                            <th>slip</th>
                            <th>-</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-close text-danger"></i> ปิดหน้าต่าง
                    </button>
                </div>
            </div>

        </div>
    </div>


<?php
$url_to_show_slip = Url::to(['report/showpayment'], true);
$js = <<<JS
  $(function(){
      
  });
    function showPay(e){
        var invoice_no = e.attr('data-var');
        if(invoice_no !=''){
           // alert(invoice_no);
            $.ajax({
              'type':'post',
              'dataType': 'html',
              'url': "$url_to_show_slip",
              'data': {'invoice_no': invoice_no },
              'success': function(data) {
                  //alert(data);
                  $(".table-list tbody").html(data);
                  $("#payModal").modal("show");
              }
            });
        }
        
        
    }
JS;

$this->registerJs($js, static::POS_END);

?>
