<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use toxor88\switchery\Switchery;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\Location */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="location-form">

    <div class="panel panel-headlin">
        <div class="panel-heading">
            <h3><i class="fa fa-institution"></i> <?=$this->title?> <small></small></h3>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
                    <br />
                               <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal form-label-left']]); ?>
                               <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ชื่อล๊อค <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">รายละเอียด
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'description')->textarea(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                </div>
                              </div>
                               <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">คลังสินค้า <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'warehouse_id')->widget(Select2::className(),[
                                      'data' => ArrayHelper::map(backend\models\Warehouse::find()->all(),'id','name'),
                                      'options' => ['placeholder'=>'เลือกคลังสินค้า']
                                   ])->label(false) ?>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">สถานะ
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php echo $form->field($model, 'status')->widget(Switchery::className(),['options'=>['label'=>'','class'=>'form-control']])->label(false) ?>
                                </div>
                              </div>


                             <div class="ln_solid"></div>
                        <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                  <?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success']) ?>
                                </div>
                        </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
</div>

