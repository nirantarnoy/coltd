<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use toxor88\switchery\Switchery;

/* @var $this yii\web\View */
/* @var $model backend\models\Import */
/* @var $form yii\widgets\ActiveForm */

$this->registerCss('
   .table-importline tr th,.table-importline tr td{
        white-space: nowrap;
   }
 ');
?>

<div class="import-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-body">
        <div class="row">
            <div class="col-lg-6">
                <?= $form->field($model, 'invoice_no')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'invoice_date')->widget(DatePicker::className(),[
                    'value' =>date('Y/m/d')
                ]) ?>
            </div>
        </div>
       <div class="row">
           <div class="col-lg-6">
               <?php echo $form->field($model, 'status')->widget(Switchery::className(),['options'=>['label'=>'','class'=>'form-control']])->label() ?>
           </div>
       </div>

        <?php //echo $form->field($model, 'vendor_id')->textInput() ?>


        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-body">
            <div class="table-responsive" style="overflow-x: scroll;">
            <table class="table table-importline">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>รายการ</th>
                        <th>ราคา ลัง(USD)</th>
                        <th>ราคา ลัง(BAHT)</th>
                        <th>จำนวน</th>
                        <th>PACKING</th>
                        <th>ราคา/ขวด</th>
                        <th>ราคารวม</th>
                        <th>จำนวนขวด</th>
                        <th>น้ำหนักลิตร</th>
                        <th>น้ำหนัก</th>
                        <th>น้ำหนักรวมหีบห่อ</th>
                        <th>เลขที่ใบขนขาเข้า</th>
                        <th>รายการที่</th>
                        <th>พิกัด</th>
                        <th>ประเทศต้นกำเนิด</th>
                        <th>รหัสสินค้าสรรพสามิต</th>
                        <th>วันที่ (ค.ส)</th>
                        <th>กนอ</th>
                        <th>วันที่</th>
                        <th>ใบอนุญาต</th>
                        <th>วันที่</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                    <td><input type="text" class="form-control" name="" value=""></td>
                </tr>
                </tbody>
            </table>

            </div>
                <div class="btn btn-default"><i class="fa fa-plus-circle"></i> เพิ่มรายการ</div>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
