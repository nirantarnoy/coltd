<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CustumerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ลูกค้า';
$this->params['breadcrumbs'][] = $this->title;

$completed = '';
?>
<div class="chk-alert">
    <?php
    $session = Yii::$app->session;
    if($session->getFlash('msg')){
      $completed = "completed";
    }
    ?>
    <div class="tst3"></div>
</div>
<div class="custumer-index">

    <?php Pjax::begin();?>
    <div class="panel panel-headline">
        <div class="panel-heading">
            <div class="btn-group">
                <?= Html::a(Yii::t('app', '<i class="fa fa-plus"></i> สร้างลูกค้า'), ['create'], ['class' => 'btn btn-success']) ?>
            </div>
            <h4 class="pull-right"><?=$this->title?> <i class="fa fa-user"></i><small></small></h4>
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
                        <form id="form-perpage" class="form-inline" action="<?=Url::to(['customer/index'],true)?>" method="post">
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
                'layout'=>'{items}{summary}{pager}',
                'summary' => "แสดง {begin} - {end} ของทั้งหมด {totalCount} รายการ",
                'showOnEmpty'=>false,
                'tableOptions' => ['class' => 'table table-hover'],
                'emptyText' => '<br /><div style="color: red;align: center;"> <b>ไม่พบรายการไดๆ</b></div>',
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    'code',
                    'first_name',
                    'last_name',
                   // 'card_id',
                    [
                            'attribute'=>'customer_group_id',
                            'value' => function($data){
                               return \backend\models\Customergroup::findName($data->customer_group_id);
                            }
                    ],

                    //'customer_type_id',
                    //'description',
                    [
                        'attribute'=>'status',
                        'contentOptions' => ['style' => 'vertical-align: middle'],
                        'format' => 'html',
                        'value'=>function($data){
                            return $data->status === 1 ? '<div class="label label-success">Active</div>':'<div class="label label-red">Inactive</div>';
                        }
                    ],
                    //'created_at',
                    //'updated_at',
                    //'created_by',
                    //'updated_by',

                    //['class' => 'yii\grid\ActionColumn'],
                    [

                        'header' => '',
                        'headerOptions' => ['style' => 'text-align:center;','class' => 'activity-view-link',],
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'text-align: right'],
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
<?php
$js=<<<JS
 $(function() {
     var comp = "$completed";
     if(comp == "completed"){
        // $(".tst3").click(function(){
           $.toast({
            heading: 'แจ้งผลการทำงาน',
            text: 'ระบบทำการลบข้อมูลที่คุณต้องการลบแล้ว',
            position: 'top-right',
            loaderBg:'#ff6849',
            icon: 'success',
            hideAfter: 3500, 
            stack: 6
          });

     //});
     }
   $("#sa-warning1").click(function(){
      swal({   
            title: "คุณต้องการลบข้อมูลนี้ใช่หรือไม่?",   
            text: "ข้อมูลนี้จะถูกลบแบบถาวรเลยนะ!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "ตกลง",   
            cancelButtonText: "เลิกทำ",   
            closeOnConfirm: false 
        }, function(){   
            swal("ลบข้อมูลเรียบร้อยแล้ว!", "ระบบทำการลบข้อมูลที่คุณต้องการให้แล้ว.", "success"); 
        }); 
   });
   
 });
    function recDelete(e){
            //e.preventDefault();
            var url = e.attr("data-url");
          //  alert(url);
            swal({   
                title: "คุณต้องการลบข้อมูลนี้ใช่หรือไม่?",   
                text: "ข้อมูลนี้จะถูกลบแบบถาวรเลยนะ!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "ตกลง",   
                cancelButtonText: "เลิกทำ",   
                closeOnConfirm: false 
            }, function(){  
                  e.attr("href",url); 
                  e.trigger("click"); 
                //  swal("ลบข้อมูลเรียบร้อยแล้ว!", "ระบบทำการลบข้อมูลที่คุณต้องการให้แล้ว.", "success"); 
            });
    }
JS;
$this->registerJs($js,static::POS_END);
?>
