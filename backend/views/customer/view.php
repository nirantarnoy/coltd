<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Custumer */

$this->title = $model->code;
$this->params['breadcrumbs'][] = ['label' => 'ลูกค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="custumer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('แก้ไข', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('ลบ', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('พิมพ์สัญญายืม [long]', ['printlongrentmaster', 'id' => $model->id], ['target'=>'_blank','class' => 'btn btn-secondary']) ?>
        <?= Html::a('พิมพ์สัญญายืม [short]', ['printshortrentmaster', 'id' => $model->id], ['target'=>'_blank','class' => 'btn btn-secondary']) ?>
    </p>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            //'id',
                            'code',
                            'first_name',
                            'last_name',
                            'card_id',
                            //'customer_group_id',
                           // 'customer_type_id',
                            [
                                'attribute' => 'customer_group_id',
                                'value'=> function($data){
                                  return \backend\models\Custumergroup::findName($data->customer_group_id);
                                }
                            ],
                            'description',
                            [
                                'attribute'=>'delivery_type',
                                'value'=>function($data){
                                    return \backend\helpers\DeliveryType::getTypeById($data->delivery_type);
                                }
                            ],
                            [
                                'attribute'=>'status',
                                'format'=>'raw',
                                'value'=>function($data){
                                    return "<label class='label label-warning'>".\backend\helpers\CustomerStatus::getTypeById($data->status)."</label>";
                                }
                            ],
//                            'created_at',
//                            'updated_at',
//                            'created_by',
//                            'updated_by',
                        ],
                    ]) ?>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        เอกสารประกอบการอนุมัติ
                    </div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>ชื่อไฟล์</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(count($modeldoc)):?>
                            <?php $i = 0;?>
                            <?php foreach ($modeldoc as $value):?>
                                <?php $i +=1;?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td>
                                        <?=$value->name?>
                                    </td>
                                    <td>
                                        <a href="uploads/documents/<?=$value->name?>" class="btn btn-secondary" target="_blank"><i class="fa fa-print"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        <?php endif;?>
                        </tbody>


                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        ประวัติการซื้อ
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        รู้จักเราจาก
                    </div>
                    <?php if(count($modelseeme)>0):?>
                        <?php $x = 0;?>
                        <?php foreach ($modelseeme as $value):?>
                            <input type="checkbox" id="bucket_checkbox_<?=$x?>" class="filled-in chk-col-cyan" checked disabled />
                            <label for="bucket_checkbox_<?=$x?>"><?=\backend\helpers\SeeType::getTypeById($value->itemid)?></label>
                            <?php $x+=1;?>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        สนใจสินค้า
                    </div>
                    <table class="table table-bordered">
                        <?php if(count($modelitem)>0):?>

                            <?php foreach ($modelitem as $value):?>
                                <tr>
                                    <td style="width: 70%"><?=\backend\helpers\item::getTypeById($value->itemid)?></td>
                                    <td style="width: 30%"><?=$value->qty?></td>
                                </tr>
                            <?php endforeach;?>
                        <?php endif;?>
                    </table>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        ต้องการยืมถัง
                    </div>
                    <table class="table table-bordered">
                        <?php if(count($modelbucket)>0):?>

                            <?php foreach ($modelbucket as $value):?>
                                <tr>
                                    <td style="width: 70%"><?=\backend\helpers\Bucket::getTypeById($value->itemid)?></td>
                                    <td style="width: 30%"><?=$value->qty?></td>
                                </tr>
                            <?php endforeach;?>
                        <?php endif;?>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        ภาพถ่ายร้าน/บริษัท
                    </div>
                    <?php if(count($modelfile)>0): ?>
                        <?php $list = [];?>
                        <?php foreach ($modelfile as $value):?>
                            <?php array_push($list,
                                [
                                    'url' => '../web/uploads/images/'.$value->name,
                                    'src' => '../web/uploads/thumbnail/'.$value->name,
                                    'options' =>[
                                        'title' => 'ทดสอบรูปภาพ',
                                        'style' => ['width'=>20]
                                    ],
                                    'template'=>""
                                ]
                            );?>
                        <?php endforeach;?>
                        <?= dosamigos\gallery\Gallery::widget(['items' => $list]);?>
                    <?php endif;?>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        แผนที่
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
