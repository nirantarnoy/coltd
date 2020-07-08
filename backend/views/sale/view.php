<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\Sale */

$this->title = $model->sale_no;
$this->params['breadcrumbs'][] = ['label' => 'Invoice', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$this->registerCss('
  .borderless td, .borderless th {
    border: none;
    padding: 5px;15px;5px;35px;
  }
');


?>
<div class="sale-view">

    <p>
        <?= Html::a('<i class="fa fa-pencil"></i> แก้ไข', ['update', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="fa fa-trash-o"></i> ลบ', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php echo Html::a('<i class="fa fa-print"></i> พิมพ์', ['printinvoice', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </p>




    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3><i class="fa fa-shopping-cart"></i> รายละเอียดเลขที่ <small><?= $model->sale_no?></small></h3>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'options'=>['class'=>'borderless'],
                        'attributes' => [
                            'sale_no',
                            [
                                 'attribute'=>'require_date',
                                 'value'=>function($data){
                                    return date('d/m/Y',$data->require_date);
                                 }
                            ],
                            [
                                'attribute'=>'customer_id',
                                'value'=>function($data){
                                    return \backend\models\Customer::findFullname($data->customer_id);
                                }
                            ],
                            'customer_ref',
                            'delvery_to',
                            [
                                'attribute'=>'currency',
                                'value'=>function($data){
                                    return \backend\helpers\Currency::getTypeById($data->currency);
                                }
                            ],
//                            'disc_amount',
//                            'disc_percent',
//                            'total_amount',

                        ],
                    ]) ?>
                </div>
                <div class="col-lg-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'options'=>['class'=>'borderless'],
                        'attributes' => [
                            [
                                'attribute'=>'quotation_id',
                                'value'=>function($data){
                                    return \backend\models\Quotation::findNum($data->quotation_id);
                                }
                            ],
                            [
                                'attribute'=>'status',
                                'format' => 'raw',
                                'value' => function($data){
                                    if($data->status == 1){
                                        return "<div class='label label-success'> Opened</div>";
                                    }else{
                                        return "<div class='label label-danger'> Completed</div>";
                                    }
                                }
                            ],
                            [
                                'attribute'=>'created_at',
                                'value'=>function($data){
                                    return date('d/m/Y',$data->created_at);
                                }
                            ],
                            [
                                'attribute'=>'updated_at',
                                'value'=>function($data){
                                    return date('d/m/Y',$data->updated_at);
                                }
                            ],
                            [
                                'attribute'=>'created_by',
                                'value'=>function($data){
                                    return \backend\models\User::findName($data->created_by);
                                }
                            ],
                            [
                                'attribute'=>'updated_by',
                                'value'=>function($data){
                                    return \backend\models\User::findName($data->updated_by);
                                }
                            ],
                            'note',
                        ],
                    ]) ?>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="panel panel-headline">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-quotation">
                            <thead>
                            <tr style="background-color: #00afe1;color: #ffffff">
                                <th style="width: 5%">#</th>
                                <th>รหัสสินค้า</th>
                                <th>รายละเอียด</th>
                                <th style="width: 10%">จำนวน</th>
                                <th style="width: 10%">ทุน</th>
                                <th>ราคา</th>
                                <th>รวม</th>
<!--                                <th>-</th>-->

                            </tr>
                            </thead>
                            <tbody>
                            <?php $total_all = 0;?>
                            <?php if(count($modelline) >0):?>
                                <?php $i=0;?>

                                <?php foreach ($modelline as $value):?>
                                <?php
                                    $i+=1;
                                    $total_all+=$value->price * $value->qty;
                                ?>
                                <tr data-var="<?=$value->id?>">
                                    <td style="vertical-align: middle;text-align: center">
                                        <?=$i?>
                                    </td>
                                    <td>
                                        <input type="hidden" class="productid" name="productid[]" value="<?=$value->product_id?>">
                                       <?=\backend\models\Product::findEng($value->product_id)?>
                                    </td>
                                    <td>
                                       <?=\backend\models\Product::findName($value->product_id)?>
                                    </td>
                                    <td style="text-align: right">
                                        <?=$value->qty?>
                                    </td>
                                    <td style="text-align: right">
                                        <?=\backend\models\Product::findProductinfo($value->product_id)->cost?>
                                    </td>
                                    <td style="text-align: right">
                                        <?=$value->price?>
                                    </td>
                                    <td style="text-align: right">
                                        <?=number_format($value->price * $value->qty,2)?>
                                    </td>

                                </tr>

                            <?php endforeach;?>
                            <?php endif;?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="5"></td>
                                <td style="text-align: right;font-weight: bold">ยอดรวม</td>
                                <td style="text-align: right;font-weight: bold" class="total-sum"><?=number_format($total_all,2)?></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--    <div class="row">-->
<!--        <div class="panel panel-headline">-->
<!--            <div class="panel-heading">-->
<!--                <h3><i class="fa fa-truck"></i> Picking Slip <small></small></h3>-->
<!--                <div class="clearfix"></div>-->
<!--            </div>-->
<!--            <div class="panel-body">-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <div class="panel">
        <div class="panel-heading">
            <h3><i class="fa fa-truck"></i> ประวัติ packing</h3>
        </div>
        <div class="panel-body">
            <div class="panel-group" id="accordion">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">รายการ</a></li>
                    <!--                <li><a data-toggle="tab" href="#menu1">รายละอียด</a></li>-->
                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <?php if(!$model->isNewRecord):?>
                            <?php if(count($modelpick) > 0):?>
                                <?php $i = 0;?>
                                <?php foreach ($modelpick as $value):?>
                                    <?php $i+=1;?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$i?>">
                                                    <?=$value->picking_no?> <label class="label label-success"><?=date('d/m/Y',$value->trans_date)?></label></a> <span class="pull-right"><div data-var="<?=$value->id?>" class="btn btn-pincking-invoice btn-danger" onclick="pickinginv($(this))"><i class='fa fa-print'></i>  พิมพ์</div></span>
                                            </h4>
                                            <form id="form-<?=$value->id?>" method="post" action="<?=Url::to(['sale/bill','id'=>$value->id],true)?>" target="_blank"></form>
                                        </div>
                                        <div id="collapse<?=$i?>" class="panel-collapse collapse out">
                                            <div class="panel-body">
                                                <table>
                                                    <?php foreach ($modelpickline as $val):?>
                                                        <?php if($value->id == $val->picking_id):?>
                                                            <tr>
                                                                <td>1</td>
                                                                <td><?=$val->product_id?></td>
                                                                <td><?=$val->qty?></td>
                                                                <td></td>
                                                            </tr>
                                                        <?php endif;?>
                                                    <?php endforeach;?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            <?php endif;?>
                        <?php endif;?>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <h3>Menu 1</h3>
                        <p>Some content in menu 1.</p>
                    </div>

                </div>




            </div>
        </div>
    </div>


</div>
<?php
$js=<<<JS
function pickinginv(e){
     var x = "#form-"+e.attr('data-var');
   
     $(x).submit();
    
 }
JS;
$this->registerJs($js,static::POS_END);
?>
