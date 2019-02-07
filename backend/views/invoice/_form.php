<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-form">
    <div class="panel panel-headline">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-lg-4">
                <div class="row">
                    <label for="">ลูกค้า</label>
                    <input type="text" class="form-control" name="customer">
                </div>
                <br>
                <div class="row">
                    <label for="">ที่อยู่</label>
                    <textarea name="" class="form-control" id="" cols="30" rows="3"></textarea>
                </div>
            </div>
            <div class="col-lg-4">

            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'invoice_no')->textInput(['maxlength' => true,'readonly'=>'readonly']) ?>
                <?= $form->field($model, 'invoice_date')->textInput() ?>
                <?= $form->field($model, 'sale_id')->textInput(['value'=>\backend\models\Picking::findSo($model->sale_id),'readonly'=>'readonly']) ?>
            </div>
        </div>
            <div class="row">
                <div class="col-lg-12">
                    <h3>INVOICE</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="text-align: center">รายการสินค้า</th>
                                <th style="text-align: right">จำนวน</th>
                                <th style="text-align: right">ราคา</th>
                                <th style="text-align: right">รวม</th>
                                <th style="text-align: center"></th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php if(!$model->isNewRecord):?>
                              <?php $i=0;?>

                           <?php endif;?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php //echo $form->field($model, 'disc_amount')->textInput() ?>

            <?php //echo $form->field($model, 'disc_percent')->textInput() ?>

            <?php //echo $form->field($model, 'total_amount')->textInput() ?>
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'note')->textarea(['maxlength' => true]) ?>
                </div>
            </div>


            <?php //echo $form->field($model, 'status')->textInput() ?>

            <?php //echo $form->field($model, 'created_at')->textInput() ?>

            <?php //echo $form->field($model, 'updated_at')->textInput() ?>

            <?php //echo $form->field($model, 'created_by')->textInput() ?>

            <?php //echo $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
    </div>
</div>
