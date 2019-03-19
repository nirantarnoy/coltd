<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

use common\models\Province;
use common\models\Amphur;
use common\models\District;
use common\models\Bank;
use yii\helpers\Url;
use lavrentiev\widgets\toastr\Notification;
use yii2mod\alert\Alert;

/* @var $this yii\web\View */
/* @var $model backend\models\Plant */
/* @var $form yii\widgets\ActiveForm */

$prov = Province::find()->all();
$amp = Amphur::find()->all();
$dist = District::find()->all();
//$bank = Bank::find()->all();

?>



  <?php $session = Yii::$app->session;
      if ($session->getFlash('msg')): ?>
       <!-- <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <?php //echo $session->getFlash('msg'); ?>
      </div> -->
        <?php echo Notification::widget([
            'type' => 'success',
            'title' => 'แจ้งผลการทำงาน',
            'message' => $session->getFlash('msg'),
          //  'message' => 'Hello',
            'options' => [
                "closeButton" => false,
                "debug" => false,
                "newestOnTop" => false,
                "progressBar" => false,
                "positionClass" => "toast-top-center",
                "preventDuplicates" => false,
                "onclick" => null,
                "showDuration" => "300",
                "hideDuration" => "1000",
                "timeOut" => "6000",
                "extendedTimeOut" => "1000",
                "showEasing" => "swing",
                "hideEasing" => "linear",
                "showMethod" => "fadeIn",
                "hideMethod" => "fadeOut"
            ]
        ]); ?>
        <?php endif; ?>
        <div class="panel panel-headlin">
            <div class="panel-heading">
                <h3><i class="fa fa-institution"></i> <?=$this->title?> <small></small></h3>

                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                    <br />
                        <?php $form = ActiveForm::begin(['options'=>['enctype' => 'multipart/form-data','class'=>'form-horizontal form-label-left']]); ?>
                           <input type="hidden" class="has_edit" name="has_edit" value="">
                           <input type="hidden" class="has_remove" name="has_remove[]" value="">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?=Yii::t('app','ชื่อบริษัท')?> <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                </div>
                              </div>
                               <div class="form-group" style="margin-top: -10px">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?=Yii::t('app','ชื่อย่อ')?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'short_name')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                </div>
                              </div>
                               <div class="form-group" style="margin-top: -10px">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?=Yii::t('app','ชื่อภาษาอังกฤษ')?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'eng_name')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                </div>
                              </div>
                               <div class="form-group" style="margin-top: -10px">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?=Yii::t('app','รายละเอียด')?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'description')->textarea(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                </div>
                              </div>
                             <div class="form-group" style="margin-top: -10px">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?=Yii::t('app','เลขประจำตัวผู้เสียภาษี')?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'tax_id')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                </div>
                              </div>
                <div class="form-group" style="margin-top: -10px">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?=Yii::t('app','เลขใบอนุญาต')?>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'permit_no')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                    </div>
                </div>
                                <div class="form-group" style="margin-top: -10px">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?=Yii::t('app','อีเมล์')?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'email')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                </div>
                              </div>
                                <div class="form-group" style="margin-top: -10px">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?=Yii::t('app','มือถือ')?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'mobile')->textInput(['maxlength' => 10,'class'=>'form-control'])->label(false) ?>
                                </div>
                              </div>
                                <div class="form-group" style="margin-top: -10px">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?=Yii::t('app','โทร')?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'phone')->textInput(['maxlength' => 10,'class'=>'form-control'])->label(false) ?>
                                </div>
                              </div>
                               <div class="form-group" style="margin-top: -10px">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?=Yii::t('app','เว็บไซต์')?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'website')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                </div>
                              </div>

                                <div class="form-group" style="margin-top: -10px">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?=Yii::t('app','Facebook')?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'facebook')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                </div>
                              </div>
                                <div class="form-group" style="margin-top: -10px">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?=Yii::t('app','Line')?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'line')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                </div>
                              </div>
                                <div class="form-group" style="margin-top: -10px">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?=Yii::t('app','โลโก้')?>
                                </label>
                                <input type="hidden" name="old_logo" value="<?=$model->logo?>">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model, 'logo')->fileInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                </div>
                              </div>
                              <div class="form-group" style="margin-top: -10px">
                                 <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?=Yii::t('app','')?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= Html::img('@web/uploads/logo/'.$model->logo,['style'=>'width: 25%;']);?>
                                </div>
                              </div>


                        <div class="ln_solid"></div>
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="form-group" style="margin-top: -10px">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?=Yii::t('app','ที่อยู่')?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model_address_plant?$model_address_plant:$model_address, 'address')->textarea(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                </div>
                              </div>
                              <div class="form-group" style="margin-top: -10px">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?=Yii::t('app','ถนน')?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model_address_plant?$model_address_plant:$model_address, 'street')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                </div>
                              </div>
                              <div class="form-group" style="margin-top: -10px">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?=Yii::t('app','ตำบล')?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?= $form->field($model_address_plant?$model_address_plant:$model_address, 'district_id')->widget(Select2::className(),
                                    [
                                     'data'=> ArrayHelper::map($dist,'DISTRICT_ID','DISTRICT_NAME'),
                                    'options'=>['maxlength' => true,'class'=>'form-control form-inline','id'=>'district','disabled'=>'disabled'],
                                    ]

                                  )->label(false) ?>
                                </div>
                              </div>
                              <div class="form-group" style="margin-top: -10px">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?=Yii::t('app','อำเภอ')?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                   <?= $form->field($model_address_plant?$model_address_plant:$model_address, 'city_id')->widget(Select2::className(),
                                    [
                                     'data'=> ArrayHelper::map($amp,'AMPHUR_ID','AMPHUR_NAME'),
                                    'options'=>['maxlength' => true,'class'=>'form-control form-inline','id'=>'city','disabled'=>'disabled',
                                          'onchange'=>'
                                          $.post("'.Url::to(['plant/showdistrict'],true).'"+"&id="+$(this).val(),function(data){
                                          $("select#district").html(data);
                                          $("select#district").prop("disabled","");

                                        });
                                           $.post("'.Url::to(['plant/showzipcode'],true).'"+"&id="+$(this).val(),function(data){
                                                $("#zipcode").val(data);
                                              });
                                       '
                                    ],
                                    'pluginOptions'=>[
                                        'allowClear'=>true,
                                      ]
                                    ]

                                  )->label(false) ?>
                                </div>
                              </div>
                              <div class="form-group" style="margin-top: -10px">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?=Yii::t('app','จังหวัด')?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                   <?= $form->field($model_address_plant?$model_address_plant:$model_address, 'province_id')->widget(Select2::className(),
                                    [
                                     'data'=> ArrayHelper::map($prov,'PROVINCE_ID','PROVINCE_NAME'),
                                     'options'=>['maxlength' => true,'class'=>'form-control form-inline','id'=>'province',
                                       'onchange'=>'
                                          $.post("'.Url::to(['plant/showcity'],true).'"+"&id="+$(this).val(),function(data){
                                          $("select#city").html(data);
                                          $("select#city").prop("disabled","");

                                        });
                                       '
                                    ],
                                    ]

                                  )->label(false) ?>

                                </div>
                              </div>
                              <div class="form-group" style="margin-top: -10px">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?=Yii::t('app','รหัสไปรษณีย์')?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php if($model_address_plant):?>
                                        <?= $form->field($model_address_plant, 'zipcode')->textInput(['class'=>'form-control','id'=>'zipcode','style'=>'width: 20%;','readonly'=>'readonly'])->label(false) ?>
                                   <?php else:?>
                                        <?= $form->field($model_address, 'zipcode')->textInput(['class'=>'form-control','id'=>'zipcode','style'=>'width: 20%;','readonly'=>'readonly'])->label(false) ?>
                                   <?php endif;?>

                                </div>
                              </div>
                          </div>
                        </div>

                        <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                  <?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success']) ?>
                                </div>
                        </div>

    <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>



<?php
  $this->registerJs('
        $(function(){

            $(".btn-addbank").click(function(){
              $("#bankModal").modal("show");
            });
            $(".btn-add-bank").click(function(){
               var type = $("#select-bank").val();
                  var account_no = $("#select-account-no").val();
                  var account_name = $("#select-account-name").val();
                  var brances = $("#brance").val();
                  var act_type = $("#select-account-type option:selected").val();
                  var bank_text = $("#select-bank option:selected").text();
                  var bank_desc = $("#select-description").val();

                  var has_edit = $("#select-edit").val();
                 //alert(account_name);return;
                
                  if(has_edit == ""){
                      $.ajax({
                           type: "POST",
                           dataType: "html",
                           url: "'.Url::toRoute(['/plant/addbank'], true).'",
                           data: { txt: bank_text,id: type,account: account_no,brance: brances,account_type: act_type,desc: bank_desc,account_name: account_name},
                           success: function(data){
                                  //alert(data);
                                  $(".banklist").append(data);
                                }
                      });
                  }else{
                      // var clonedRow = $(".table-bank tbody tr:first").clone();
                      // clonedRow.find("input").val("");
                      // $(".table-bank tbody").append(clonedRow);

                      $(".table-bank tbody.banklist tr").each(function(){
                          var recid = $(this).closest("tr").find(".rec_id").val();
                          if(recid == has_edit){
                             
                              
                              $(this).closest("tr").find(".txt-acc-no").text(account_no);
                              $(this).closest("tr").find(".txt-acc-name").text(account_name);
                              $(this).closest("tr").find(".txt-bank-id").text(bank_text);



                              $(this).closest("tr").find(".bank_id").val(type);
                              $(this).closest("tr").find(".account_name").val(account_name);
                              $(this).closest("tr").find(".account_no").val("9000000000");
                              $(this).closest("tr").find(".account_type").val(act_type);

                              alert($(this).closest("tr").find(".account_type").val());
                              //return;
                          }
                      });

                  }

                  $("#select-description").val(0);
                  $("#bankModal").modal("hide");

            });
        });
        function bankRemove(e){
              if(confirm("ต้องการลบรายการนี้ใช่หรือไม่")){
                  var bid = e.closest("tr").find(".bank_id").val();
                  e.parents("tr").remove();
                  $(".has_edit").val(1);
              }
        }
        function bankEdit(e){
            
            
            $("#bankModal").modal("show");
            

            var bankid = e.closest("tr").find(".bank_id").val();
            var acttype = e.closest("tr").find(".account_type").val();
            var actno = e.closest("tr").find(".account_no").val();
            var actname = e.closest("tr").find(".account_name").val();
            
            $("#select-edit").val(e.closest("tr").find(".rec_id").val());
            $("#select-account-name").val(actname);
            $("#select-account-no").val(actno);
            $("#select-bank").val(bankid).change();
            $("#select-account-type").val(acttype).change();

            $(".has_edit").val(1);
        }
    ',static::POS_END);
 ?>
