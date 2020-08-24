<?php

use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;
use kartik\daterange\DateRangePicker;

$this->title = 'รายงานสรุปเจ้าหนี้';


$dateval = date('d-m-Y') . ' ถึง ' . date('d-m-Y');
if ($from_date != '' && $to_date != '') {
    $dateval = $from_date . ' ถึง ' . $to_date;
}
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

                echo ExportMenu::widget(
                    ['dataProvider' => $dataProvider,
                        'columns' =>
                            [
                                [
                                    'attribute' => 'name',
                                    'value' => function ($data) {
                                        return $data->name;
                                    },
                                    'group' => true,
                                ],

                                [
                                    'attribute' => 'invoice_no',
                                    'label' => 'INVOICE',
                                ],
                                [
                                    'attribute' => 'total_amount',
                                    'label' => 'จำนวนเงิน',
                                    'hAlign' => 'right',
                                    'format' => ['decimal', 2],
                                    'pageSummary' => true,
                                    'pageSummaryFunc' => GridView::F_SUM
                                ],
                                [
                                    'attribute' => 'amount',
                                    'label' => 'ยอดชำระ',
                                    'hAlign' => 'right',
                                    'format' => ['decimal', 2],
                                    'pageSummary' => true,
                                    'pageSummaryFunc' => GridView::F_SUM
                                ],
                                [
                                    'label' => 'หนี้คงค้าง',
                                    'value' => function ($data) {
                                        return $data->total_amount - $data->amount;
                                    },
                                    'hAlign' => 'right',
                                    'format' => ['decimal', 2],
                                    'pageSummary' => true,
                                    'pageSummaryFunc' => GridView::F_SUM
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
                    ]
                );
                ?>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-3">
                <form id="form_date" action="<?= Url::to(['report/apsummary'], true) ?>">
                    <?php
                    echo DateRangePicker::widget([
                        'name' => 'date_select',
                        'value' => $dateval,
                        'options' => ['class' => 'date_select'],
                        'presetDropdown' => true,
                        'hideInput' => true,
                        'convertFormat' => true,
                        'pluginOptions' => [
                            'locale' => ['format' => 'd-m-Y', 'separator' => ' ถึง ']
                        ]
                    ]);
                    ?>
                </form>
            </div>
        </div>
        <br>
        <div class="panel panel-body">
            <div class="table-responsive">
                <?= GridView::widget(['dataProvider' => $dataProvider,
                    // 'filterModel' => $searchModel,
                    'emptyCell' => '-',
                    'layout' => '{items}{summary} <br> {pager}',
                    'summary' => "แสดง {begin} - {end} ของทั้งหมด {totalCount} รายการ",
                    'showOnEmpty' => true,
                    //'showPageSummary'=>true,
                    'tableOptions' => ['class' => 'table table-hover'],
                    'emptyText' => '<br/><div style="color: red;align: center;"> <b>ไม่พบรายการไดๆ</b></div>',
                    'toggleDataContainer' => ['class' => 'btn-group mr-2'],
                    'columns' => [
                        [
                            'attribute' => 'name',
                            'value' => function ($data) {
                                return $data->name;
                            },
                            'group' => true,
                        ],
                        [
                            'attribute' => 'invoice_no',
                            'label' => 'INVOICE',
                        ],
                        [
                            'attribute' => 'total_amount',
                            'label' => 'จำนวนเงิน',
                            'hAlign' => 'right',
                            'format' => ['decimal', 2],
                            'pageSummary' => true,
                            'pageSummaryFunc' => GridView::F_SUM
                        ],
                        [
                            'attribute' => 'amount',
                            'label' => 'ยอดชำระ',
                            'hAlign' => 'right',
                            'format' => ['decimal', 2],
                            'pageSummary' => true,
                            'pageSummaryFunc' => GridView::F_SUM
                        ],
                        [
                            'label' => 'หนี้คงค้าง',
                            'value' => function ($data) {
                                return $data->total_amount - $data->amount;
                            },
                            'hAlign' => 'right',
                            'format' => ['decimal', 2],
                            'pageSummary' => true,
                            'pageSummaryFunc' => GridView::F_SUM
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
                    'showPageSummary' => true,// 'showFooter' => true,
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

<?php
$url_to_ap = Url::to(['report/apsummary'],true);
$js=<<<JS
   $(".date_select").change(function() {
      // alert();
       $.ajax({
           type: 'post',
           dataType: 'html',
           url: '$url_to_ap',
           data: {'find_date': $(this).val()},
           success: function(data){
               //alert(data);
           }
       });
    });
JS;
$this->registerJs($js,static::POS_END);
?>
