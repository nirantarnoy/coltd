<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StockbalanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'สินค้าคงคลัง';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stockbalance-index">
    <?php Pjax::begin();?>
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
                <div class="col-lg-9">
                    <div class="form-inline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="pull-right">
                        <form id="form-perpage" class="form-inline" action="<?=Url::to(['stockbalance/index'],true)?>" method="post">
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
       // 'filterModel' => $searchModel,
        'emptyCell'=>'-',
        'layout'=>'{items}{summary}{pager}',
        'summary' => "แสดง {begin} - {end} ของทั้งหมด {totalCount} รายการ",
        'showOnEmpty'=>false,
        'tableOptions' => ['class' => 'table table-hover'],
        'emptyText' => '<br /><div style="color: red;align: center;"> <b>ไม่พบรายการไดๆ</b></div>',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            [
                'attribute' => 'product_id',
                'format' => 'raw',
                'value' => function($data){
                   return Html::a(\backend\models\Product::findCode($data->product_id), ['product/view', 'id' => $data->product_id]);
                }
            ],
            [
                'attribute' => 'product_id',
                'format' => 'raw',
                'label' => 'ชื่อสินค้า',
                'value' => function($data){
                    return Html::a(\backend\models\Product::findName($data->product_id), ['product/view', 'id' => $data->product_id]);
                }
            ],
            [
                'attribute' => 'warehouse_id',
                'format' => 'html',
                'value' => function($data){
                    return Html::a(\backend\models\Warehouse::findWarehousename($data->warehouse_id), ['warehouse/view', 'id' => $data->warehouse_id]);
                }
            ],
            [
                'attribute' => 'loc_id',
                'value' => function($data){
                    return \backend\models\location::findLocationname($data->loc_id);
                }
            ],
            'qty',
            //'status',
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',

          //  ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
        </div>
    </div>
