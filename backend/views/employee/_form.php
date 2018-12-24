<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use toxor88\switchery\Switchery;


/* @var $this yii\web\View */
/* @var $model backend\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>
        <div class="panel panel-headlin">
            <div class="panel-heading">
                <h3><i class="fa fa-institution"></i> <?=$this->title?> <small></small></h3>
                <!-- <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#">Settings 1</a>
                      </li>
                      <li><a href="#">Settings 2</a>
                      </li>
                    </ul>
                  </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul> -->
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <br />
                                <?php $form = ActiveForm::begin(['options'=>['enctype' => 'multipart/form-data','class'=>'form-horizontal form-label-left']]); ?>


                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">รหัสพนักงาน <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'emp_code')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">คำนำหน้า <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'prefix')->widget(Select2::className(),[
                            'data'=>ArrayHelper::map(\backend\helpers\PersonPrefix::asArrayObject(),'id','name'),
                            'options' => ['placeholder'=>'เลือก']
                        ])->label(false) ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ชื่อ <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'first_name')->textInput(['maxlength' => true])->label(false) ?>
                    </div>
                </div>
                <input type="hidden" name="old_photo" value="<?=$model->photo?>">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">นามสกุล <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">เพศ
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'gender_id')->widget(Select2::className(),[
                            'data'=>ArrayHelper::map(\backend\helpers\GenderType::asArrayObject(),'id','name'),
                            'options' => ['placeholder'=>'เลือก']
                        ])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">แผนก
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'section_id')->widget(Select2::className(),[
                            'data'=>ArrayHelper::map(\backend\models\Section::find()->all(),'id','name'),
                            'options' => ['placeholder'=>'เลือก']
                        ])->label(false) ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ตำแหน่ง
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'position_id')->widget(Select2::className(),[
                            'data'=>ArrayHelper::map(\backend\models\Position::find()->all(),'id','name'),
                            'options' => ['placeholder'=>'เลือก']
                        ])->label(false) ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ประเภทค่าจ้าง
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'salary_type')->widget(Select2::className(),[
                            'data'=>ArrayHelper::map(\backend\helpers\SalaryType::asArrayObject(),'id','name'),
                            'options' => ['placeholder'=>'เลือก']
                        ])->label(false) ?>
                    </div>
                </div>


                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">บันทึก
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'description')->textarea(['maxlength' => true])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">รูปภาพ
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <a href="../web/uploads/img_profile/<?=$model->photo?>" target="_blank"><?=$model->photo;?></a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'photo')->fileInput(['maxlength' => true])->label(false) ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">สถานะ
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php echo $form->field($model, 'status')->widget(Switchery::className(),['options'=>['label'=>'','class'=>'form-control']])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                </div>


                                <?php ActiveForm::end(); ?>

</div>
        </div>
