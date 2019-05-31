<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductstockSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="productstock-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>


    <?= $form->field($model, 'productSearch')->textInput(['placeholder'=>'รหัสสินค้า,ชื่อสินค้า'])->label(false) ?>

    <?= $form->field($model, 'warehouse_id')->widget(Select2::className(),[
            'data'=>ArrayHelper::map(\backend\models\Warehouse::find()->all(),'id','name'),
        'options' => ['placeholder'=>'คลังสินค้า........','class'=>'form-inline'],
        'pluginOptions' => [
                'allowClear'=>true,
        ]
    ])->label(false) ?>




    <div class="form-group" style="margin-top: -10px">
        <?= Html::submitButton('ค้นหา', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('เคลียร์', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
