<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use toxor88\switchery\Switchery;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Currencyrate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel panel-headlin">
    <div class="panel-heading">
        <h3><i class="fa fa-institution"></i> <?=$this->title?> <small></small></h3>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <br />

        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-lg-3"><?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>
            <div class="col-lg-3">
                <?= $form->field($model, 'from_currency')->widget(Select2::className(),[
                    'data' => ArrayHelper::map(backend\models\Currency::find()->all(),'id','name'),
                    'options' => ['placeholder'=>'เลือกสกุลเงิน']
                ])->label() ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'to_integer')->widget(Select2::className(),[
                    'data' => ArrayHelper::map(backend\models\Currency::find()->all(),'id','name'),
                    'options' => ['placeholder'=>'เลือกสกุลเงิน']
                ])->label() ?>
            </div>
            <div class="col-lg-3"><?= $form->field($model, 'rate_factor')->textInput() ?></div>
        </div>
        <div class="row">
            <div class="col-lg-3"><?= $form->field($model, 'rate')->textInput() ?></div>
            <div class="col-lg-3">
                <?php $model->from_date = $model->isNewRecord?date('d/m/Y'):date('d/m/Y',strtotime($model->from_date));?>
                <?= $form->field($model, 'from_date')->widget(DatePicker::className()) ?>
            </div>
            <div class="col-lg-3">
                <?php $model->to_date = $model->isNewRecord?date('d/m/Y'):date('d/m/Y',strtotime($model->to_date));?>
                <?= $form->field($model, 'to_date')->widget(DatePicker::className()) ?>
            </div>
            <div class="col-lg-3">

            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <?php echo $form->field($model, 'status')->widget(Switchery::className(),['options'=>['label'=>'','class'=>'form-control']])->label('สถานะ') ?>
            </div>
        </div>

        <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
       </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
