<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
$this->title = 'นำเข้าสินค้า';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inboundinv-index">

    <?php $session = Yii::$app->session;
    if ($session->getFlash('msg')): ?>
        <!-- <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <?php //echo $session->getFlash('msg'); ?>
      </div> -->
<!--        --><?php //echo Notification::widget([
//            'type' => 'success',
//            'title' => 'แจ้งผลการทำงาน',
//            'message' => $session->getFlash('msg'),
//            //  'message' => 'Hello',
//            'options' => [
//                "closeButton" => false,
//                "debug" => false,
//                "newestOnTop" => false,
//                "progressBar" => false,
//                "positionClass" => "toast-top-center",
//                "preventDuplicates" => false,
//                "onclick" => null,
//                "showDuration" => "300",
//                "hideDuration" => "1000",
//                "timeOut" => "6000",
//                "extendedTimeOut" => "1000",
//                "showEasing" => "swing",
//                "hideEasing" => "linear",
//                "showMethod" => "fadeIn",
//                "hideMethod" => "fadeOut"
//            ]
//        ]); ?>
    <?php endif; ?>
    <?php Pjax::begin(); ?>
    <div class="panel panel-headline">
        <div class="panel-heading">
            <div class="btn-group">
                <?= Html::a(Yii::t('app', '<i class="fa fa-plus"></i> นำเข้าสินค้า'), ['create'], ['class' => 'btn btn-success']) ?>
            </div>
            <h4 class="pull-right"><?=$this->title?> <i class="fa fa-refresh"></i><small></small></h4>
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
                        <form id="form-perpage" class="form-inline" action="<?=Url::to(['import/index'],true)?>" method="post">
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
        'emptyCell'=>'-',
        'layout'=>"{items}{summary}<div align=\'center\'>{pager}</div>",
        'summary' => "แสดง {begin} - {end} ของทั้งหมด {totalCount} รายการ",
        'showOnEmpty'=>false,
        'tableOptions' => ['class' => 'table table-hover'],
        'emptyText' => '<br/><div style="color: red;align: center;"> <b>ไม่พบรายการไดๆ</b></div>',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'invoice_no',
            [
                'attribute'=>'invoice_date',
                'format' => 'raw',
                'value' => function($data){
                  return date('d/m/Y',strtotime($data->invoice_date));
                }
            ],
            'customer_ref',
            //'delivery_term',
            //'sold_to',
            [
                'attribute'=>'total_amount',
                'headerOptions' => ['style'=>'text-align: right'],
                'contentOptions' => ['style'=>'text-align: right'],
                'format' => 'html',
                'value' => function($data){
                    return number_format($data->total_amount,2);
                }
            ],
            [
                'attribute'=>'status',
                'format' => 'raw',
                'value' => function($data){
                    if($data->status == 1){
                        return "<div class='label label-success'> Open</div>";
                    }else if($data->status == 2){
                        return "<div class='label label-danger'> Completed</div>";
                    }
                }
            ],
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',

            [

                'header' => '',
                'headerOptions' => ['style' => 'text-align:center;','class' => 'activity-view-link',],
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'text-align: right'],
                'template' => '{view} {update} {inboundtrans} {payment} {delete}',
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
                        return $data->status == 1? Html::a(
                            '<span class="glyphicon glyphicon-pencil btn btn-xs btn-default"></span>', $url, [
                            'id' => 'activity-view-link',
                            //'data-toggle' => 'modal',
                            // 'data-target' => '#modal',
                            'data-id' => $index,
                            'data-pjax' => '0',
                            // 'style'=>['float'=>'rigth'],
                        ]):'';
                    },
                    'inboundtrans' => function($url, $data, $index){
                        $options = array_merge([
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'id'=>'modaledit',
                        ]);
                        return \backend\models\Inboundinv::findTrans($data->id)? Html::a(
                            '<span class="glyphicon glyphicon-link btn btn-xs btn-info"></span>', $url, [
                            'id' => 'activity-view-link',
                            //'data-toggle' => 'modal',
                            // 'data-target' => '#modal',
                            'data-id' => $index,
                            'data-pjax' => '0',
                            // 'style'=>['float'=>'rigth'],
                        ]):'';
                    },
                    'payment' => function($url, $data, $index) {
                        $options = [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                            'data-url'=>$url,
                            'data-var'=> $data->id,
                            'data-id' => \backend\models\Inboundpayment::findPayamount($data->id),
                            'onclick'=>'payment($(this));'

                        ];
                        return $data->payment_status<=1? Html::a(
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
                <i class="fa fa-tags"></i> บันทึกชำระเงิน
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <form id="form-payment" action="<?=Url::to(['inboundinv/payment'],true)?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="saleid" class="saleid" value="">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">ยอดเต็มที่ต้องชำระ</label>
                            <input type="text" class="form-control total-amount" name="total_amount" value="" readonly>
                        </div>
                        <div class="col-lg-6">
                            <label for="">ยอดค้างชำระ</label>
                            <input type="text" class="form-control total-remain-amount" name="total_remain_amount" value="" readonly>
                        </div>
                    </div>
                    <br>
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
                            <input type="text" class="form-control payment-amount" name="amount" value="" onchange="checkamount($(this))">
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
$this->registerJs('
    $(function(){
        $("#perpage").change(function(){
            $("#form-perpage").submit();
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
        var total = e.closest("tr").find("td:eq(4)").html();
        var total = total.replace(",","");
        var total_pay = e.attr("data-id");
       // alert(total);
        $("#paymentModal").modal("show").find(".saleid").val(xdata);
        $("#paymentModal").modal("show").find(".total-amount").val(total);
        $("#paymentModal").modal("show").find(".total-remain-amount").val(parseFloat(total)-parseFloat(total_pay));
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
    
    
    function checkamount(e){
        var payamount = e.val();
       
        if(payamount > 0){
           var amt = $(".total-amount").val();
           var total_payment = amt.replace(",","");
           //alert(total_payment);
           if(payamount > parseFloat(total_payment)){
              alert("จำนวนที่ชำระมากกว่ายอดที่ต้องชำระ");
              e.val(0);
              return false;
           }
        }
    }

    ',static::POS_END);
?>
