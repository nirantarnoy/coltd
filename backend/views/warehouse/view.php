<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Warehouse */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'คลังสินค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss('
  .borderless td, .borderless th {
    border: none;
    padding: 5px;15px;5px;35px;
  }
');
?>
<div class="warehouse-view">
    <div class="row">
      <div class="col-lg-12">
            <div class="btn-group">
                 <?= Html::a(Yii::t('app', '<i class="fa fa-pencil"></i> แก้ไข'), ['update', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a(Yii::t('app', '<i class="fa fa-trash"></i> ลบ'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-default',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <div class="btn btn-default"><i class="fa fa-print"></i> พิมพ์</div>
            </div>
          <div class="pull-right">
              <a href="<?=Url::to(array('warehouse/index'),true)?>"><div class="btn btn-default">กลับ <i class="fa fa-arrow-right"></i> </div></a>
          </div>
            
      </div>
     </div>
    <br>

    <div class="panel panel-headlin">
        <div class="panel-heading">
            <h3><i class="fa fa-institution"></i> รายละเอียดคลังสินค้า <small><?= $model->name?></small></h3>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-4">
                      <?= DetailView::widget([
                        'model' => $model,
                        'options'=>['class'=>'borderless'],
                        'attributes' => [
                           // 'id',
                            'name',
                            'description',
                             [
                                'attribute'=>'is_primary',
                                'format' => 'html',
                                'value'=>function($data){
                                    return $data->is_primary === 1 ?'<div class="label label-success">คลังสินค้าหลัก</div>':'<div class="label label-default">ไม่ใช่</div>';
                                }
                            ],
                            
                        ],
                    ]) ?>
                </div>
                <div class="col-lg-4">
                      <?= DetailView::widget([
                        'model' => $model,
                        'options'=>['class'=>'borderless'],
                        'attributes' => [
                           // 'id',
                           
                            [
                                'attribute'=>'status',
                                'format' => 'html',
                                'value'=>function($data){
                                    return $data->status === 1 ? '<div class="label label-success">Active</div>':'<div class="label label-default">Inactive</div>';
                                }
                            ],
                            [
                                'attribute'=>'created_at',
                                'value'=>function($data){
                                    return date('d-m-Y H:i',$data->created_at);
                                }
                            ],
                            [
                                'attribute'=>'updated_at',
                                'value'=>function($data){
                                    return date('d-m-Y H:i',$data->created_at);
                                }
                            ],
                           
                        ],
                    ]) ?>
                </div>
                <div class="col-lg-4">
                      <?= DetailView::widget([
                        'model' => $model,
                        'options'=>['class'=>'borderless'],
                        'attributes' => [
                          
                            [
                                'attribute'=>'created_by',
                                'value'=>function($data){
                                    $name = \backend\models\User::getUserinfo($data->created_by);
                                    return $name!=null?$name->username:'';
                                }
                            ],
                            [
                                'attribute'=>'updated_by',
                                'value'=>function($data){
                                     $name = \backend\models\User::getUserinfo($data->updated_by);
                                    return $name!=null?$name->username:'';
                                }
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="col-lg-12">
                      <div class="col-md-4 tile">
                          <span><b>จำนวนสินค้าทั้งหมด</b></span>
                          <h2><?=number_format($allqty,0)?> </i></h2>
                        
                          <div class="btn btn-default"> ดูรายการสินค้า</div>
                        </div>
                        <div class="col-md-4 tile">
                          <span><b>มูลค่าสินค้า</b></span>
                          <h2>0 บาท</i></h2>
                          <span class="sparkline22 graph" style="height: 160px;">
                                <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                          </span>
                        </div>
                       
                </div>
            </div>

            </div>
        </div>
    </div>

  <div class="row">
   <div class="col-md-12">
       <div class="panel panel-headlin">
           <div class="panel-heading">
                    <h2><i class="fa fa-asterisk"></i> ประวัติสินค้า เข้า-ออก <small>ล่าสุด</small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="panel-body">
                      <div class="row">
                          <?php Pjax::begin(); ?>
                          <div class="col-lg-12">
                              <?= GridView::widget([
                                  'dataProvider' => $movementDp,
                                 // 'filterModel' => $movementSearch,
                                  'emptyCell'=>'-',
                                  'layout'=>'{summary}{items}{pager}',
                                  'summary' => "แสดง {begin} - {end} ของทั้งหมด {totalCount} รายการ",
                                  'showOnEmpty'=>true,
                                  'tableOptions' => ['class' => 'table table-hover'],
                                  'emptyText' => '<div style="color: red;align: center;"> <b>ไม่พบรายการไดๆ</b></div>',
                                  'columns' => [
                                      ['class' => 'yii\grid\SerialColumn','contentOptions' => ['style' => 'vertical-align: middle;text-align: center;']],
                                      'journal_no',
                                      [
                                          'attribute' => 'product_id',
                                          'contentOptions' => ['style' => 'vertical-align: middle'],
                                          'format'=>'html',
                                          'value' => function($data){
                                              return '<a href="'.Url::to(['product/view','id'=>$data->product_id],true).'">'.\backend\models\Product::findProductcode($data->product_id).'</a>';
                                          }
                                      ],
                                      [
                                          'attribute'=>'trans_type',
                                          'contentOptions' => ['style' => 'vertical-align: middle'],
                                          'value' => function($data){
                                              return \backend\helpers\RunnoTitle::getTypeById($data->trans_type);
                                          }
                                      ],
                                      'reference',

                                      [
                                          'attribute' => 'qty',
                                          'contentOptions' => ['style' => 'vertical-align: middle'],
                                          'value' => function($data){
                                              return number_format($data->qty,0);
                                          }
                                      ],
                                      [
                                          'label'=> 'รายการ',
                                          'contentOptions' => ['style' => 'vertical-align: middle'],
                                          'format' => 'html',
                                          'value' => function($data){
                                              return "<div class='label label-success'> เข้า </div>";
                                          }

                                      ] ,

                                      [
                                          'attribute' => 'created_by',
                                          'contentOptions' => ['style' => 'vertical-align: middle'],
                                          'value' => function($data){
                                              return \backend\models\User::getUserinfo($data->created_by)->username;
                                          }
                                      ],
                                      [
                                          'attribute' => 'created_at',
                                          'contentOptions' => ['style' => 'vertical-align: middle'],
                                          'value' => function($data){
                                             return date('d-m-Y',$data->created_at);
                                          }

                                      ],
//                                      [
//                                          'attribute' => 'created_at',
//                                          'contentOptions' => ['style' => 'vertical-align: middle'],
//                                          'value' =>function($data){
//                                              return date('d-m-y h:i:s',$data->created_at);
//                                          } ,
//                                          'options' => ['class'=>'filter_date'],
//                                          'format' => 'raw',
//                                          'filter' => DateRangePicker::widget([
//                                              'model' => $movementSearch ,
//                                              // 'name'=>'niran',
//                                              'attribute' => 'created_at',
//                                              'value' => date('d-m-Y'),
//                                              'convertFormat'=>true,
//                                              'presetDropdown'=>true,
//                                              'hideInput'=>true,
//                                              'pluginOptions'=>[
//                                                  'locale'=>[
//                                                      'format'=>'d-m-Y',
//                                                      'separator'=>' to ',
//                                                  ],
//                                                  'opens'=>'left'
//                                              ]
//                                          ])
                                      ]
                               //   ],
                              ]); ?>
                          </div>
                          <?php Pjax::end(); ?>
                      </div>
                  </div>

                </div>
              </div>

 </div>

</div>
