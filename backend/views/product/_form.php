<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use toxor88\switchery\Switchery;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">
<?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal form-label-left']]); ?>
    <div class="panel panel-headline">
        <div class="panel-heading">
                    <h3><i class="fa fa-cube"></i> <?=$this->title?> <small></small></h3>

                    <div class="clearfix"></div>
                  </div>
                  <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">รหัสสินค้า <span class="required">*</span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                               <?= $form->field($model, 'product_code')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ชื่อสินค้า <span class="required"></span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                               <?= $form->field($model, 'name')->textarea(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                            </div>
                                          </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ชื่ออังกฤษ <span class="required"></span>
                                                </label>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <?= $form->field($model, 'engname')->textarea(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                                </div>
                                            </div>
                                           <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">รายละเอียด <span class="required"></span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                               <?= $form->field($model, 'description')->textarea(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                            </div>
                                          </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ต้นทุน <span class="required"></span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?= $form->field($model, 'cost')->textInput(['maxlength' => true,'class'=>'form-control','value'=>$model->cost!=""?$model->cost:0])->label(false) ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ราคา <span class="required"></span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?= $form->field($model, 'price')->textInput(['maxlength' => true,'class'=>'form-control','value'=>$model->price!=""?$model->price:0])->label(false) ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">สถานะ <span class="required"></span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?= $form->field($model, 'status')->widget(Switchery::className(),['options'=>['label'=>'','class'=>'form-control']])->label(false) ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">จำนวนสินค้า <span class="required"></span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?= $form->field($model, 'available_qty')->textInput(['maxlength' => true,'class'=>'form-control','disabled'=>'disabled','value'=>$model->available_qty!=""?$model->available_qty:0])->label(false) ?>
                                        </div>
                                    </div>


                                </div>
                                 <div class="col-lg-6">
                                     <div class="form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">หมวดสินค้า <span class="required"></span>
                                         </label>
                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                             <?= $form->field($model, 'category_id')->widget(Select2::className(),[
                                                 'data' => ArrayHelper::map(backend\models\Productcategory::find()->all(),'id','name'),
                                                 'options' => ['placeholder'=>'เลือกกลุ่มสินค้า']
                                             ])->label(false) ?>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">บาร์โค้ด <span class="required"></span>
                                         </label>
                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                             <?= $form->field($model, 'barcode')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">หน่วยนับ <span class="required"></span>
                                         </label>
                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                             <?= $form->field($model, 'unit_id')->widget(Select2::className(),[
                                                 'data' => ArrayHelper::map(backend\models\Unit::find()->all(),'id','name'),
                                                 'options' => ['placeholder'=>'เลือกหน่วยนับ']
                                             ])->label(false) ?>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ปริมาณต่อลัง <span class="required"></span>
                                         </label>
                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                             <?= $form->field($model, 'volumn')->textInput()->label(false) ?>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ปริมาณต่อขวด/ลิตร <span class="required"></span>
                                         </label>
                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                             <?= $form->field($model, 'unit_factor')->textInput()->label(false) ?>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Aclohol Content <span class="required"></span>
                                         </label>
                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                             <?= $form->field($model, 'volumn_content')->textInput()->label(false) ?>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Origin Country <span class="required"></span>
                                         </label>
                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                             <?= $form->field($model, 'origin')->textInput()->label(false) ?>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Net weight <span class="required"></span>
                                         </label>
                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                             <?= $form->field($model, 'netweight')->textInput()->label(false) ?>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Gross weight <span class="required"></span>
                                         </label>
                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                             <?= $form->field($model, 'grossweight')->textInput()->label(false) ?>
                                         </div>
                                     </div>



                                 </div>

                            </div>

                           <hr />

                        <div class="col-md-8 col-md-offset-4">
                           <?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success']) ?>
                           <?php if(!$model->isNewRecord):?>
                            <div class="btn btn-default"><a href="<?=Url::to(['product/view/','id'=>$model->id],true)?>">ดูรายละเอียด</a></div>
                          <?php endif;?>
                            <div class="btn btn-danger"><a style="color: #FFF" href="<?=Url::to(['product/index'],true)?>">ยกเลิก</a></div>
                        </div>
                  </div>
    </div>

    <?php ActiveForm::end(); ?>



</div>
