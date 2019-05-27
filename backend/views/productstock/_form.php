<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Productstock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="productstock-form">
    <div class="panel panel-headline">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'warehouse_id')->widget(Select2::className(),[
            'data'=>ArrayHelper::map(\backend\models\Warehouse::find()->all(),'id','name'),
            'options' => ['placeholder'=>'เลือก'],
    ]) ?>

    <?= $form->field($model, 'in_qty')->textInput() ?>

    <?= $form->field($model, 'out_qty')->textInput() ?>

    <?= $form->field($model, 'invoice_no')->textInput(['maxlength' => true]) ?>
     <?php $invdate = $model->isNewRecord?date('d-m-Y'):date('d-m-Y',strtotime($model->invoice_date));?>
    <?= $form->field($model, 'invoice_date')->widget(DatePicker::className(),[
            'value' => $invdate
    ]) ?>

    <?= $form->field($model, 'transport_in_no')->textInput(['maxlength' => true]) ?>

            <?php $tranindate = $model->isNewRecord?date('d-m-Y'):date('d-m-Y',strtotime($model->transport_in_date));?>
            <?= $form->field($model, 'transport_in_date')->widget(DatePicker::className(),[
                'value' => $tranindate
            ]) ?>

    <?= $form->field($model, 'sequence')->textInput() ?>

    <?= $form->field($model, 'permit_no')->textInput(['maxlength' => true]) ?>

            <?php $perdate = $model->isNewRecord?date('d-m-Y'):date('d-m-Y',strtotime($model->permit_date));?>
            <?= $form->field($model, 'permit_date')->widget(DatePicker::className(),[
                'value' => $perdate
            ]) ?>

    <?= $form->field($model, 'kno_no_in')->textInput(['maxlength' => true]) ?>

            <?php $knodate = $model->isNewRecord?date('d-m-Y'):date('d-m-Y',strtotime($model->kno_in_date));?>
            <?= $form->field($model, 'kno_in_date')->widget(DatePicker::className(),[
                'value' => $knodate
            ]) ?>

    <?= $form->field($model, 'usd_rate')->textInput() ?>

    <?= $form->field($model, 'thb_amount')->textInput() ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
