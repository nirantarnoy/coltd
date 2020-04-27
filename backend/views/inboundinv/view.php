<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Inboundinv */

$this->title = $model->invoice_no;
$this->params['breadcrumbs'][] = ['label' => 'นำเข้าสินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="inboundinv-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'invoice_no',
            'invoice_date',
            'customer_ref',
            'sold_to',
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
            [
                    'attribute'=>'created_at',
                'value'=>function($data){
                    return date('d-m-Y',$data->created_at);
                }
            ]
          //  'created_at',
//            'updated_at',
//            'created_by',
//            'updated_by',
        ],
    ]) ?>

</div>
