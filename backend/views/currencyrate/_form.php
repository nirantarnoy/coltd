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
$mode = $model->isNewRecord?'create':'update';
?>

<div class="panel panel-headlin">
    <div class="panel-heading">
        <h3><i class="fa fa-institution"></i> <?=$this->title?> <small></small></h3>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <br />
<div class="alert alert-danger" style="display: none">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <p><b>พบว่ามีข้อมูลอัตราแลกเปลี่ยนของเดือนที่ต้องการแล้ว</b></p>
</div>
        <?php $form = ActiveForm::begin(['options' =>['id'=>'form-currency'] ]); ?>
        <input type="hidden" class="form-mode" value="<?=$mode?>">
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
                <?= $form->field($model, 'from_date')->widget(DatePicker::className(),
                    [
                            'options' => [ 'class' =>'from_date'],
                            'pluginOptions' => [
                                    'format'=>'dd/mm/yyyy',
                            ]
                    ]) ?>
            </div>
            <div class="col-lg-3">
                <?php $model->to_date = $model->isNewRecord?date('d/m/Y'):date('d/m/Y',strtotime($model->to_date));?>
                <?= $form->field($model, 'to_date')->widget(DatePicker::className(),
                    [
                        'pluginOptions' => [
                            'format'=>'dd/mm/yyyy'
                        ]
                    ]) ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'rate_type')->widget(Select2::className(),[
                    'data' => ArrayHelper::map(backend\helpers\RateType::asArrayObject(),'id','name'),
                    'options' => ['placeholder'=>'เลือกประเภท','class'=>'rate_type']
                ])->label('ใช้กับ') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <?php echo $form->field($model, 'status')->widget(Switchery::className(),['options'=>['label'=>'','class'=>'form-control']])->label('สถานะ') ?>
            </div>
        </div>

        <div class="form-group">
            <div class="btn btn-success btn-save">Save</div>
        <?php //echo // Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
       </div>

    <?php ActiveForm::end(); ?>

</div>
</div>

<?php
$url_to_check_rate = \yii\helpers\Url::to(['currencyrate/checkmonth'],true);
$js=<<<JS
 $(function() {
   $(".btn-save").click(function() {
       let mode = $(".form-mode").val();
       if(mode =='create'){
            let c_date = $(".from_date").val();
            let rate_type = $(".rate_type").val();
            let arr = c_date.split('/');
            let m = 0;
            if(arr.length > 0){
                m=arr[1];
            }
            // alert(m);
             $.ajax({
                'type':'post',
                'dataType':'html',
                'url':'$url_to_check_rate',
                'data':{'find_month': m,'find_type': rate_type},
                'success': function(data) {
                   if(data == 1){
                       $(".alert").show();
                   }else{
                       $(".alert").hide();
                   }
                }
             });
       }else{
           $("#form-currency").submit();
       }
      
   });
 });
JS;

$this->registerJs($js,static::POS_END);

?>
