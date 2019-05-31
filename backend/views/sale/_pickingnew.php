<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductstockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'PickingList';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="productstock-index">

    <div class="panel panel-headline">
        <div class="panel-heading">
            <h4 class="pull-left"><i class="fa fa-cubes text-warning"></i><small> เลือกสินค้าสำหรับ Saleorder เลขที่ </small>  <?=$order_no?> </h4>
            <div class="btn btn-success btn-select-item pull-right"> เลือกรายการ </div>
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
                <div class="col-lg-9">
                    <div class="form-inline">
                        <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>
                    </div>
                </div>
                <div class="col-lg-3">

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
                    'id' => 'my-grid',
                    'options' => ['style' => 'white-space:nowrap; font-size: 16px'],
                    'emptyText' => '<br /><div style="color: red;align: center;"> <b>ไม่พบรายการไดๆ</b></div>',
                    'rowOptions' => function ($model) {
                        if ($model->sequence == 0) {
                            return ['class' => 'info'];
                        }
                    },
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        ['class' => 'yii\grid\CheckboxColumn'],
                        // 'id',
                        ['attribute' => 'product_id','value'=>function($data){
                            return \backend\models\Product::findCode($data->product_id);
                        }],
                        ['attribute' => 'warehouse_id','value'=>function($data){
                            return \backend\models\Warehouse::findWarehousename($data->warehouse_id);
                        }],
                        ['attribute' => 'in_qty','value'=>function($data){
                            return $data->in_qty!=null?$data->in_qty:0;
                        }],
                        ['attribute' => 'out_qty','format'=>'raw','value'=>function($data){
                            //  return $data->in_qty!=null?$data->in_qty:0;
                            return Html::textInput('',$data->out_qty);
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
                        ['attribute' => 'usd_rate','value'=>function($data){
                              return $data->in_qty!=null?$data->in_qty:0;
                            //return Html::textInput('',$data->usd_rate);
                        }],
                        'thb_amount',
                        //'status',
                        //'created_at',
                        //'updated_at',
                        //'created_by',
                        //'updated_by',

                       // ['class' => 'yii\grid\ActionColumn'],
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
     $(".btn-select-item").click(function() {
        var keys = $("#my-grid").yiiGridView("getSelectedRows");
        console.log(keys);
     });
     
    $("#perpage").change(function(){
            $("#form-perpage").submit();
        });
 });
JS;

$this->registerJs($js,static::POS_END);

?>
