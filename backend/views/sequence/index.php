<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use lavrentiev\widgets\toastr\Notification;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SequenceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'ลำดับเอกสาร');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sequence-index">
  <?php $session = Yii::$app->session;
      if ($session->getFlash('msg') || $session->getFlash('msg-error') ): ?>
       <!-- <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <?php //echo $session->getFlash('msg');
              $alert_type = $session->getFlash('msg')?"success":"error";
              $message = $session->getFlash('msg')?$session->getFlash('msg'):$session->getFlash('msg-error');

       // ?>
      </div> -->
        <?php echo Notification::widget([
            'type' => $alert_type,
            'title' => 'แจ้งผลการทำงาน',
            'message' => $message,
          //  'message' => 'Hello',
            'options' => [
                "closeButton" => false,
                "debug" => false,
                "newestOnTop" => false,
                "progressBar" => false,
                "positionClass" => "toast-top-center",
                "preventDuplicates" => false,
                "onclick" => null,
                "showDuration" => "300",
                "hideDuration" => "1000",
                "timeOut" => "6000",
                "extendedTimeOut" => "1000",
                "showEasing" => "swing",
                "hideEasing" => "linear",
                "showMethod" => "fadeIn",
                "hideMethod" => "fadeOut"
            ]
        ]); ?> 
        <?php endif; ?>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="panel panel-headlin">
        <div class="panel-heading">
                    <div class="btn-group">
                       <?= Html::a(Yii::t('app', '<i class="fa fa-plus"></i> สร้างลำดับเอกสาร'), ['create'], ['class' => 'btn btn-success']) ?>
                     </div>
                     <div class="btn-group">
                         <div class="btn btn-primary btn-auto">
                             <i class="fa fa-adn"></i> สร้างอัตโนมัติ
                         </div>

                    </div>
                   
                    <h4 class="pull-right"><?=$this->title?> <i class="fa fa-institution"></i> <small></small></h4>
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
                                  <form id="form-perpage" class="form-inline" action="<?=Url::to(['sequence/index'],true)?>" method="post">
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
        'emptyText' => '<div style="color: red;align: center;"> <b>ไม่พบรายการไดๆ</b></div>',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','contentOptions' => ['style' => 'vertical-align: middle']],

            //'id',
            //'plant_id',
            [
                'attribute'=>'module_id',
                'contentOptions' => ['style' => 'vertical-align: middle'], 
                'value'=>function($data){
                   return \backend\helpers\RunnoTitle::getTypeById($data->module_id);
                } 
            ],
            [
                'attribute'=>'prefix',
                'contentOptions' => ['style' => 'vertical-align: middle'],  
            ],
            [
                'attribute'=>'symbol',
                'contentOptions' => ['style' => 'vertical-align: middle;'],  
            ],
            //'use_year',
            //'use_month',
            //'use_day',
            [
                'attribute'=>'minimum',
                'headerOptions'=>['style'=>'text-align: right;'],
                'contentOptions' => ['style' => 'vertical-align: middle;text-align: right;'],  
            ],
            [
                'attribute'=>'maximum',
                'headerOptions'=>['style'=>'text-align: right;'],
                'contentOptions' => ['style' => 'vertical-align: middle;text-align: right;'],  
            ],
            [
                'attribute'=>'currentnum',
                'headerOptions'=>['style'=>'text-align: right;'],
                'contentOptions' => ['style' => 'vertical-align: middle;text-align: right;'],  
            ],
             [
                'label'=>'รูปแบบ',
                'headerOptions'=>['style'=>'text-align: left;'],
                'contentOptions' => ['style' => 'vertical-align: middle;'], 
                'value'=> function($data){
                   $full = "";
                   $use_year = "";
                   $use_month = "";
                   $use_day = "";
                   for($i=0;$i<=strlen($data->maximum)-1;$i++){
                    $full.="0";
                   }
                   if($data->use_year){
                       $use_year = date('y');
                   }
                   if($data->use_month){
                        $use_month = date('y');
                   }
                   if($data->use_day){
                        $use_day = date('y');
                    }
                   return $data->prefix.$data->symbol.$use_year.$use_month.$use_day.$full;
                } 
            ],
            //'status',
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',

           [
                                                       'attribute'=>'status',
                                                       'contentOptions' => ['style' => 'vertical-align: middle'],  
                                                       'format' => 'html',
                                                       'value'=>function($data){
                                                         return $data->status === 1 ? '<div class="label label-success">Active</div>':'<div class="label label-default">Inactive</div>';
                                                       }
                                                      ],
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
                </div>
            </div>
        </div>
    <?php Pjax::end(); ?>
</div>
<?php
     $url_to_gen = Url::to(['sequence/autogen'],true);
$this->registerJsFile( '@web/js/sweetalert.min.js',['depends' => [\yii\web\JqueryAsset::className()]],static::POS_END);
$this->registerCssFile( '@web/css/sweetalert.css');
     $this->registerJs('
         $(function(){
            $(".btn-auto").click(function(){
                swal({
                  title: "ยืนยัน",
                  text: "คุณต้องการให้ระบบสร้างเลขที่อัตโนมัติใช่หรือไม่",
                  type: "warning",
                  showCancelButton: true,
                  closeOnConfirm: false,
                  showLoaderOnConfirm: true
                }, function () {
                     $.ajax({
                        type: "post",
                        dataType: "html",
                        url: "'.$url_to_gen.'",
                        data: {autogen: 1},
                        success: function(data){
                          alert(data);
                        }
                     });
                });
            });
         });
         function recDelete(e){
        //e.preventDefault();
        var url = e.attr("data-url");
        //var url ="'.Url::to(['product/delete','id'=>10],true).'" ;
        //alert(url);
        swal({
              title: "ต้องการลบรายการนี้ใช่หรือไม่",
              text: "",
              type: "warning",
              showCancelButton: true,
              closeOnConfirm: false,
              showLoaderOnConfirm: true
            }, function () {
              e.attr("href",url); 
              e.trigger("click");        
        });
    }
            
',static::POS_END)?>
