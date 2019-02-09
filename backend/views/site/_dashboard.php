<?php
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;
use miloschuman\highcharts\Highcharts;

$this->title = "Dashboard";

$dateval = date('d-m-Y').' ถึง '.date('d-m-Y');
if($from_date !='' && $to_date != ''){
    $dateval = $from_date.' ถึง '.$to_date;
}


?>

<div class="panel">
    <div class="panel-heading">


        <div class="row">
            <div class="col-lg-3">
                <h3><?=$this->title?></h3>
            </div>
            <div class="col-lg-3"></div>
            <div class="col-lg-3"></div>
            <div class="col-lg-3">
                <form id="form_date" action="<?=Url::to(['site/index'],true)?>">
                    <?php
                    echo DateRangePicker::widget([
                        'name'=>'date_select',
                        'value' => $dateval,
                        'options' => ['class'=>'date_select'],
                        'presetDropdown' => true,
                        'hideInput' => true,
                        'convertFormat' => true,
                        'pluginOptions' => [
                            'locale'=>['format'=>'d-m-Y','separator'=>' ถึง ']
                        ]
                    ]);
                    ?>
                </form>
            </div>
        </div>

    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3">
                <div class="metric">
                    <span class="icon"><i class="fa fa-cube"></i></span>
                    <p>
                        <span class="number"><?=number_format($all_sale_qty,0)?></span>
                        <span class="title">ยอดขาย(จำนวน)</span>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric">
                    <span class="icon"><i class="fa fa-money"></i></span>
                    <p>
                        <span class="number"><?=number_format($all_sale_amount,0)?></span>
                        <span class="title">ยอดขาย(เงิน)</span>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric">
                    <span class="icon"><i class="fa fa-shopping-bag"></i></span>
                    <p>
                        <span class="number"><?=number_format($all_rec_qty,0)?></span>
                        <span class="title">จำนวนรับเข้า(จำนวน)</span>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric">
                    <span class="icon"><i class="fa fa-money text-success"></i></span>
                    <p>
                        <span class="number"><?=number_format($all_rec_amount,0)?></span>
                        <span class="title">จำนวนรับเข้า(เงิน)</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">เปรียบเทียบยอดขาย</h3>
                        <div class="right">
                            <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
                            <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
                        </div>
                    </div>
                    <div class="panel-body">
                        <!--                                <div id="visits-trends-chart" class="ct-chart"></div>-->
                        <?php
                        $month = ['Jan', 'Feb', 'Mar', 'Apl', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                        $plan = ["เหล้า","ไวน์"];
                        //$po = [1500,1590];
                        echo Highcharts::widget([
                            'options' => [
                                'class'=>'compare_chart',
                                'title' => ['text' => ''],
                                'xAxis' => [
                                    'categories' => $month
                                ],
                                'yAxis' => [
                                    'title' => ['text' => 'จำนวนเ']
                                ],
                                'series' => [
                                    ['name' => $plan[0], 'data' => [100,200,450,350,400,689,550,300,450,200,600,1200]],
                                    ['name' => $plan[1], 'data' => [200,200,450,350,490,690,280,500,550,100,800,1290]],

                                ],
                                'credits' => ['enabled' => true],
                                'chart' => [
                                    'type' => 'line',
                                ],
                            ]
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$js=<<<JS
   $(".date_select").change(function() {
      $("form#form_date").submit();
    });
JS;
$this->registerJs($js,static::POS_END);
?>
