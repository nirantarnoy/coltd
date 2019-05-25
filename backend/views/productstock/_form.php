<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Productstock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="productstock-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'warehouse_id')->textInput() ?>

    <?= $form->field($model, 'in_qty')->textInput() ?>

    <?= $form->field($model, 'out_qty')->textInput() ?>

    <?= $form->field($model, 'invoice_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_date')->textInput() ?>

    <?= $form->field($model, 'transport_in_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'transport_in_date')->textInput() ?>

    <?= $form->field($model, 'sequence')->textInput() ?>

    <?= $form->field($model, 'permit_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'permit_date')->textInput() ?>

    <?= $form->field($model, 'kno_no_in')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kno_in_date')->textInput() ?>

    <?= $form->field($model, 'usd_rate')->textInput() ?>

    <?= $form->field($model, 'thb_amount')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
