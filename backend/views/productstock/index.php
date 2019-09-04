<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductstockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'สินค้าคงคลัง';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="productstock-index">

    <div class="panel panel-headline">
        <div class="panel-heading">
            <h4 class="pull-left"><i class="fa fa-cubes text-warning"></i><small></small> <?=$this->title?> </h4>
            <!-- <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Settings 1</a>
                  </li>
                  <li><a href="#">Settings 2</a>
                  </li>
                </ul>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul> -->
            <div class="clearfix"></div>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <?php

                    echo ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            // 'id',
                            ['attribute' => 'product_id','value'=>function($data){
                                return \backend\models\Product::findCode($data->product_id);
                            }],
                            ['attribute' => 'product_id','value'=>function($data){
                                return \backend\models\Product::findName($data->product_id);
                            }],
                            ['attribute' => 'warehouse_id','value'=>function($data){
                                return \backend\models\Warehouse::findWarehousename($data->warehouse_id);
                            }],
                            [
                                'attribute' => 'in_qty',
                                'headerOptions' => ['style'=>'background-color: green;color: white'],
                                'contentOptions' => ['style'=>'background-color: green;color: white;text-align: right'],
                                'value'=>function($data){
                                    return $data->in_qty!=null?$data->in_qty:0;
                                }],
                            [
                                'attribute' => 'out_qty',
                                'headerOptions' => ['style'=>'background-color: orange;color: white'],
                                'contentOptions' => ['style'=>'background-color: orange;color: white;text-align: right'],
                                'value'=>function($data){
                                    return $data->out_qty!=null?$data->out_qty:0;
                                }],
                            'invoice_no',
                            ['attribute' => 'invoice_date','value'=>function($data){
                                return date('d-m-Y',strtotime($data->invoice_date));
                            }],
                            'transport_in_no',
                            ['attribute' => 'transport_in_date','value'=>function($data){
                                return date('d-m-Y',strtotime($data->transport_in_date));
                            }],
                            ['attribute' => 'sequence','value'=>function($data){
                                return $data->sequence!=null?$data->sequence:0;
                            }],
                            'permit_no',
                            ['attribute' => 'permit_date','value'=>function($data){
                                return date('d-m-Y',strtotime($data->permit_date));
                            }],
                            'kno_no_in',
                            ['attribute' => 'kno_in_date','value'=>function($data){
                                return date('d-m-Y',strtotime($data->kno_in_date));
                            }],
                            'usd_rate',
                            'thb_amount',


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
            <div class="row">
                <div class="col-lg-9">
                    <div class="form-inline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="pull-right">
                        <form id="form-perpage" class="form-inline" action="<?=Url::to(['productstock/index'],true)?>" method="post">
                            <div class="form-group">
                                <label>แสดง </label>
                                <select class="form-control" name="perpage" id="perpage">
                                    <option value="20" <?=$perpage=='20'?'selected':''?>>20</option>
                                    <option value="50" <?=$perpage=='50'?'selected':''?> >50</option>
                                    <option value="100" <?=$perpage=='100'?'selected':''?>>100</option>
                                </select>
                                <label> รายการ</label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="table-responsive" >
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'emptyCell'=>'-',
        'layout'=>"{items}\n{summary}\n<div class='text-left'>{pager}</div>",
        'summary' => "แสดง {begin} - {end} ของทั้งหมด {totalCount} รายการ",
        'showOnEmpty'=>false,
        'tableOptions' => ['class' => 'table table-hover table-condensed'],
        'options' => ['style' => 'white-space:nowrap; font-size: 14px'],
        'emptyText' => '<br /><div style="color: red;align: center;"> <b>ไม่พบรายการไดๆ</b></div>',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            ['attribute' => 'product_id','value'=>function($data){
                return \backend\models\Product::findCode($data->product_id);
            }],
            ['attribute' => 'product_id','value'=>function($data){
                return \backend\models\Product::findName($data->product_id);
            }],
            ['attribute' => 'warehouse_id','value'=>function($data){
                return \backend\models\Warehouse::findWarehousename($data->warehouse_id);
            }],
            [
                    'attribute' => 'in_qty',
                'headerOptions' => ['style'=>'background-color: green;color: white'],
                'contentOptions' => ['style'=>'background-color: green;color: white;text-align: right'],
                'value'=>function($data){
                return $data->in_qty!=null?$data->in_qty:0;
            }],
            [
                'attribute' => 'out_qty',
                'headerOptions' => ['style'=>'background-color: orange;color: white'],
                'contentOptions' => ['style'=>'background-color: orange;color: white;text-align: right'],
                'value'=>function($data){
                    return $data->out_qty!=null?$data->out_qty:0;
                }],
            'invoice_no',
            ['attribute' => 'invoice_date','value'=>function($data){
               return date('d-m-Y',strtotime($data->invoice_date));
            }],
            'transport_in_no',
            ['attribute' => 'transport_in_date','value'=>function($data){
                return date('d-m-Y',strtotime($data->transport_in_date));
            }],
            ['attribute' => 'sequence','value'=>function($data){
                return $data->sequence!=null?$data->sequence:0;
            }],
            'permit_no',
            ['attribute' => 'permit_date','value'=>function($data){
                return date('d-m-Y',strtotime($data->permit_date));
            }],
            'kno_no_in',
            ['attribute' => 'kno_in_date','value'=>function($data){
                return date('d-m-Y',strtotime($data->kno_in_date));
            }],
            'usd_rate',
            'thb_amount',
            //'status',
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'condensed' => false,
        'responsive' => false,
        'containerOptions' => ['style'=>'overflow-y: '],
        'resizableColumnsOptions' => ['resizeFromBody' => true],
        'hover' => true,


    ]); ?>
            </div>
    <?php Pjax::end(); ?>

</div>
    </div>
</div>
<?php
$js=<<<JS
 $(function() {
    $("#perpage").change(function(){
            $("#form-perpage").submit();
        });
 });
JS;

$this->registerJs($js,static::POS_END);

?>
