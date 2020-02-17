<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Productstock */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Productstocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="productstock-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
       //     'id',
           [
                   'attribute'=>'product_id',
                   'value' => function($data){
                     return \backend\models\Product::findName($data->product_id);
                   }
           ],
            [
                'attribute'=>'warehouse_id',
                'value' => function($data){
                    return \backend\models\Warehouse::findWarehousename($data->warehouse_id);
                }
            ],
            'in_qty',
            'out_qty',
            'invoice_no',
            'invoice_date',
            'transport_in_no',
            'transport_in_date',
            'sequence',
            'permit_no',
            'permit_date',
            'kno_no_in',
            'kno_in_date',
            'usd_rate',
            'thb_amount',
//            'status',
//            'created_at',
//            'updated_at',
//            'created_by',
//            'updated_by',
        ],
    ]) ?>

</div>
