<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\StockbalanceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stockbalance-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'productSearch')->textInput(['placeholder'=>'รหัสสินค้า/ชื่อสินค้า'])->label(false) ?>

    <?= $form->field($model, 'warehouse_id')->widget(Select2::className(),[
        'data'=>ArrayHelper::map(\backend\models\Warehouse::find()->all(),'id','name'),
        'options' => [
            'placeholder'=>'เลือกคลังสินค้า'
        ],
        'pluginOptions' => [
                'allowClear'=> true,
        ]
    ])->label(false) ?>

    <?= $form->field($model, 'loc_id')->widget(Select2::className(),[
        'data'=>ArrayHelper::map(\backend\models\Location::find()->all(),'id','name'),
        'options' => [
            'placeholder'=>'เลือกล๊อค'
        ],
        'pluginOptions' => [
            'allowClear'=> true,
        ]
    ])->label(false) ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">

        <?= Html::submitButton('ค้นหา', ['class' => 'btn btn-primary','style'=>'margin-top: -10px;']) ?>
        <?= Html::resetButton('รีเซ็ต', ['class' => 'btn btn-default','style'=>'margin-top: -10px;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
