<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Addressbook */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="addressbook-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'address_type_id')->textInput() ?>

    <?= $form->field($model, 'party_type_id')->textInput() ?>

    <?= $form->field($model, 'party_id')->textInput() ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'district_id')->textInput() ?>

    <?= $form->field($model, 'city_id')->textInput() ?>

    <?= $form->field($model, 'province_id')->textInput() ?>

    <?= $form->field($model, 'zipcode')->textInput() ?>

    <?= $form->field($model, 'is_primary')->textInput() ?>

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
