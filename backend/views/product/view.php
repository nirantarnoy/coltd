<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use kartik\daterange\DateRangePicker;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->registerCss('
  .borderless td, .borderless th {
    border: none;
    padding: 5px;15px;5px;35px;
  }
');

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'สินค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">
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
        <div class="btn btn-default"><i class="fa fa-barcode"></i> พิมพ์บาร์โค้ด</div>
            </div>
          <div class="pull-right">
              <a href="<?=Url::to(['product/index'],true)?>"><div class="btn btn-default">กลับ <i class="fa fa-arrow-right"></i> </div></a>
          </div>

      </div>
     </div>
<div class="row" style="margin-top: 5px;">
  <div class="col-lg-12">
      <div class="panel panel-headline">
          <div class="panel-heading">
            <h3><i class="fa fa-cube"></i> รายละเอียดสินค้า <small><?= $model->name?></small></h3>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">

           <div class="row">
               <div class="col-lg-4">
                   <?= DetailView::widget([
                        'model' => $model,
                        'options'=>['class'=>'borderless'],
                        'attributes' => [
                         //   'id',
                            'product_code',
                            'engname',
                            'name',
                            'description',
                            'barcode',

                            [
                                          'attribute'=>'unit_id',
                                          'headerOptions' => ['style' => 'text-align: left'],
                                          'contentOptions' => ['style' => 'vertical-align: middle'],
                                          'value'=> function($data){
                                            return \backend\models\Unit::findUnitname($data->unit_id);
                                          }
                                     ],
                                     [
                                          'attribute'=>'category_id',
                                          'headerOptions' => ['style' => 'text-align: left'],
                                          'contentOptions' => ['style' => 'vertical-align: middle'],
                                           'value'=> function($data){
                                            return \backend\models\Productcategory::findName($data->category_id);
                                          }
                                      ],
                            'volumn',
                            'volumn_content',
                            'unit_factor',

                        ],
                    ]) ?>
                     <!-- <div class="btn btn-default" style="margin-top: 5px;"> ดูตามที่จัดเก็บ</div> -->
               </div>
               <div class="col-lg-4">
                   <?= DetailView::widget([
                        'model' => $model,
                        'options'=>['class'=>'borderless'],
                        'attributes' => [

                            [
                                'attribute'=>'cost',
                                'value'=>function($data){
                                    return $data->cost!=''?number_format($data->cost,0):0;
                                }
                            ],
                            [
                                'attribute'=>'price',
                                'value'=>function($data){
                                    return $data->price!=''?number_format($data->price,0):0;
                                }
                            ],
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
               <div class="col-lg-4">
                <div class="row">

                        <div class="col-md-6 tile">
                          <span><b>จำนวนสินค้า</b></span>
                          <h2><?=$model->available_qty!=""?number_format($model->available_qty):0?></h2>
                          <span class="sparkline22 graph" style="height: 160px;">
                                <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                          </span>
                        </div>
                </div>

<!--                    <i class="fa fa-warning"></i> <small class="text-danger"> คลิกดูรายการจำนวนสินค้าที่ตัวเลขจำนวน</small> -->
               </div>
           </div>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                    <?php if(1): ?>
                        <?php $list = [];?>
                        <?php foreach ($productimage as $value):?>
                            <?php array_push($list,
                                [
                                    'url' => '../web/uploads/images/'.$value->name,
                                    'src' => '../web/uploads/thumbnail/'.$value->name,
                                    'options' =>[
                                        'title' => 'ทดสอบรูปภาพ',
                                        'style' => ['width'=>20]
                                    ]
                                ]
                            );?>
                        <?php endforeach;?>

                    <?php endif;?>
                    <?php $items = [
                        [
                            'url' => 'http://farm8.static.flickr.com/7429/9478294690_51ae7eb6c9_b.jpg',
                            'src' => 'http://farm8.static.flickr.com/7429/9478294690_51ae7eb6c9_s.jpg',
                            'options' => array('title' => 'Camposanto monumentale (inside)')
                        ],
                        [
                            'url' => 'http://farm4.static.flickr.com/3825/9476606873_42ed88704d_b.jpg',
                            'src' => 'http://farm4.static.flickr.com/3825/9476606873_42ed88704d_s.jpg',
                            'options' => array('title' => 'Sail us to the Moon')
                        ],
                        [
                            'url' => 'http://farm4.static.flickr.com/3749/9480072539_e3a1d70d39_b.jpg',
                            'src' => 'http://farm4.static.flickr.com/3749/9480072539_e3a1d70d39_s.jpg',
                            'options' => array('title' => 'Sail us to the Moon')
                        ],

                    ];?>
                    <?= dosamigos\gallery\Gallery::widget(['items' => $list]);?>
                </div>
            </div>

       </div>
 </div>
</div>
</div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-heading">
                    <h4>ข้อมูลราคาสินค้า</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table">
                                <thaed>
                                    <tr>
                                        <th>#</th>
                                        <th>เลขที่ใบขน</th>
                                        <th>วันที่ใบขน</th>
                                        <th>เลขที่ใบอนุญาต</th>
                                        <th>วันที่ใบอนุญาต</th>
                                        <th>สรรพสามิตร</th>
                                        <th>วันที่</th>
                                        <th>ราคา</th>
                                    </tr>
                                </thaed>
                                <tbody>
                                <?php if(!$model->isNewRecord):?>
                                    <?php if(count($modelcost) > 0):?>
                                        <?php $i = 0;?>
                                        <?php foreach ($modelcost as $value):?>
                                            <?php $i +=1;?>
                                            <tr>
                                                <td><?=$i?></td>
                                                <td><?=$value->transport_in_no?></td>
                                                <td><?=$value->transport_in_date?></td>
                                                <td><?=$value->permit_no?></td>
                                                <td><?=$value->permit_date?></td>
                                                <td><?=$value->excise_no?></td>
                                                <td><?=$value->excise_date?></td>
                                                <td><?=$value->cost?></td>
                                            </tr>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                <?php endif;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





</div>

<?php $this->registerCss('
   .card {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    width: 20%;
    float: left;
    margin: 5px;
    }
    
    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }
    .card-container {
        padding: 2px 16px;
    }
');?>
