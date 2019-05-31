<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SaleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ขายสินค้า';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-index">
    <?php Pjax::begin();?>
    <div class="panel panel-headline">
        <div class="panel-heading">
            <div class="btn-group">
                <?= Html::a(Yii::t('app', '<i class="fa fa-plus"></i> สร้างรายการขาย'), ['create'], ['class' => 'btn btn-success']) ?>
            </div>
            <h4 class="pull-right"><?=$this->title?> <i class="fa fa-shopping-cart"></i><small></small></h4>
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
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="pull-right">
                        <form id="form-perpage" class="form-inline" action="<?=Url::to(['sale/index'],true)?>" method="post">
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
            <div class="table-responsive">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'emptyCell'=>'-',
        'layout'=>"{items}\n{summary}\n<div class='text-center'>{pager}</div>",
        'summary' => "แสดง {begin} - {end} ของทั้งหมด {totalCount} รายการ",
        'showOnEmpty'=>false,
        'tableOptions' => ['class' => 'table table-hover'],
        'emptyText' => '<br /><div style="color: red;align: center;"> <b>ไม่พบรายการไดๆ</b></div>',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'id',
            'sale_no',
          //  'revise',
            [
                'attribute'=>'require_date',
                'value' => function($data){
                    return date('d/m/Y',$data->require_date);
                }
            ],
            [
                'attribute'=>'customer_id',
                'value' => function($data){
                    return \backend\models\Customer::findName($data->customer_id);
                }
            ],
            //'customer_ref',
            //'delvery_to',
            //'currency',
            //'sale_id',
            //'disc_amount',
            //'disc_percent',
            //'total_amount',
            //'quotation_id',
            //'note',
            [
                'attribute'=>'status',
                'format' => 'raw',
                'value' => function($data){
                   if($data->status == 1){
                       return "<div class='label label-success'>".\backend\helpers\SaleStatus::getTypeById($data->status)."</div>";
                   }else if($data->status == 2){
                       return "<div class='label label-danger'>".\backend\helpers\SaleStatus::getTypeById($data->status)."</div>";
                   }
                }
            ],
            [
                    'attribute' => 'created_at',
                    'value'=>function($data){
                       return date('d/m/Y',$data->created_at);
                    }
            ],
            //'updated_at',
            //'created_by',
            //'updated_by',

            [

                'header' => '',
                'headerOptions' => ['style' => 'text-align:center;','class' => 'activity-view-link',],
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'text-align: right'],
                'template' => '{view} {update} {payment} {delete}',
                'buttons' => [
                    'view' => function($url, $data, $index) {
                        $options = [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ];
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open btn btn-xs btn-default"></span>', $url, $options);
                    },
                    'update' => function($url, $data, $index) {
                        $options = array_merge([
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'id'=>'modaledit',
                        ]);
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil btn btn-xs btn-default"></span>', $url, [
                            'id' => 'activity-view-link',
                            //'data-toggle' => 'modal',
                            // 'data-target' => '#modal',
                            'data-id' => $index,
                            'data-pjax' => '0',
                            // 'style'=>['float'=>'rigth'],
                        ]);
                    },
                    'payment' => function($url, $data, $index) {
                        $options = [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                            'data-url'=>$url,
                            'data-var'=> $data->id,
                            'onclick'=>'payment($(this));'

                        ];
                        return \backend\models\Picking::checkPick($data->id)==1? Html::a(
                            '<span class="glyphicon glyphicon-tags btn btn-xs btn-default"></span>', 'javascript:void(0)', $options)
                            :'';
                    },
                    'delete' => function($url, $data, $index) {
                        $options = array_merge([
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            //'data-method' => 'post',
                            //'data-pjax' => '0',
                            'data-url'=>$url,
                            'onclick'=>'recDelete($(this));'
                        ]);
                        return Html::a('<span class="glyphicon glyphicon-trash btn btn-xs btn-default"></span>', 'javascript:void(0)', $options);
                    }
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
            </div>
        </div>
</div>
</div>


<div id="paymentModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-tags"></i> บันทึกรับเงิน
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <form id="form-payment" action="<?=Url::to(['sale/payment'],true)?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="saleid" class="saleid" value="">
                <div class="row">
                    <div class="col-lg-6">
                        <label for="">วันที่</label>
                        <?php
                            echo DatePicker::widget([
                                    'name'=>'payment_date',
                                    'value' => date('Y/m/d'),
                            ])
                        ?>
                    </div>

                    <div class="col-lg-6">
                        <label for="">จำนวนเงิน</label>
                        <input type="text" class="form-control payment-amount" name="amount" value="">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-6">
                        <label class="control-label">เวลา</label>
                        <?php echo TimePicker::widget(['name' => 'payment_time']);?>
                    </div>
                </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Notes</label>
                            <textarea name="note" class="form-control" id="" cols="30" rows="3"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">แนบหลักฐาน</label>
                            <input type="file" name="payment_slip">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-payment" data-dismiss="modal"><i class="fa fa-close text-danger"></i> บันทึกรายการ</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close text-danger"></i> ปิดหน้าต่าง</button>
            </div>
        </div>

    </div>
</div>


<?php
$this->registerJsFile( '@web/js/sweetalert.min.js',['depends' => [\yii\web\JqueryAsset::className()]],static::POS_END);
$this->registerCssFile( '@web/css/sweetalert.css');
//$url_to_delete =  Url::to(['product/bulkdelete'],true);
$js=<<<JS
 $(function(){
        $("#perpage").change(function(){
            $("#form-perpage").submit();
        });
        $(".payment-amount").on("keypress",function(event){
           $(this).val($(this).val().replace(/[^0-9\.]/g,""));
           if((event.which != 46 || $(this).val().indexOf(".") != -1) && (event.which <48 || event.which >57)){event.preventDefault();}
        });
        $(".btn-payment").click(function(){
            $("form#form-payment").submit();
        });
    });

   function recDelete(e){
        //e.preventDefault();
        var url = e.attr("data-url");
        swal({
              title: "ต้องการลบรายการนี้ใช่หรือไม่",
              text: "",
              type: "error",
              showCancelButton: true,
              closeOnConfirm: false,
              showLoaderOnConfirm: true
            }, function () {
              e.attr("href",url); 
              e.trigger("click");        
        });
    }
    function payment(e){
        //e.preventDefault();
        //var url = e.attr("data-url");
        var xdata = e.attr("data-var");
       // alert(xdata);
        $("#paymentModal").modal("show").find(".saleid").val(xdata);
        // swal({
        //       title: "ต้องการลบรายการนี้ใช่หรือไม่",
        //       text: "",
        //       type: "error",
        //       showCancelButton: true,
        //       closeOnConfirm: false,
        //       showLoaderOnConfirm: true
        //     }, function () {
        //       e.attr("href",url); 
        //       e.trigger("click");        
        // });
    }
JS;

$this->registerJs($js,static::POS_END);
?>
