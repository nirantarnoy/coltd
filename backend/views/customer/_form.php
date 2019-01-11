<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use toxor88\switchery\Switchery;
use yii\helpers\Url;

use common\models\Province;
use common\models\Amphur;
use common\models\District;
/* @var $this yii\web\View */
/* @var $model backend\models\Custumer */
/* @var $form yii\widgets\ActiveForm */
$custgroup = \backend\models\Customergroup::find()->all();


$add_prov = $model_address_plant?$model_address_plant->province_id:0;
$add_amp = $model_address_plant?$model_address_plant->city_id:0;

$prov = Province::find()->all();
$amp = Amphur::find()->where(['PROVINCE_ID'=>$add_prov])->all();
$dist = District::find()->where(['AMPHUR_ID'=> $add_amp])->all();

$l = 1;
$old_item = '';
$m = 1;
$old_bucket = '';
$old_seeme = [];
if(count($item_select)>0){
    foreach ($item_select as $value){
        if($l < count($item_select)){
            $old_item .=$value->itemid.',';
        }else if($l == count($item_select)){
            $old_item .=$value->itemid;
        }
        $l+=1;
    }
}
if(count($bucket)>0) {
    foreach ($bucket as $value) {
        if ($m < count($bucket)) {
            $old_bucket .= $value->itemid . ',';
        } else if ($m == count($bucket)) {
            $old_bucket .= $value->itemid;
        }
        $m += 1;
    }
}
$url_to_findcity = Url::to(['plant/showcity'],true);
$url_to_finddistrict = Url::to(['plant/showdistrict'],true);
$url_to_findzipcode = Url::to(['plant/showzipcode'],true);
$js=<<<JS

   $(function(){
      
   });

  function findCity(e){
        $.post("$url_to_findcity" +"&id="+e.val(),function(data){
             $("select#city").html(data);
             $("select#city").prop("disabled","");

        });
                                          
  }
  function findDistrict(e){
        $.post("$url_to_finddistrict"+"&id="+e.val(),function(data){
             $("select#district").html(data);
             $("select#district").prop("disabled","");
        });
        $.post("$url_to_findzipcode"+"&id="+e.val(),function(data){
            $("#zipcode").val(data);
        });
                                          
  }
  
JS;
$this->registerJs($js,static::POS_END);

?>
<input type="hidden" name="cur_cus" class="cur_cus" value="<?=$model->id;?>">
<div class="custumer-form">
    <div class="panel">
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

            <div class="row">
                <div class="col-lg-3">
                    <?= $form->field($model, 'code')->textInput(['maxlength' => true,'data-validation-required-message'=>'กรุณาป้อนข้อมูลรหัสลูกค้า']) ?>
                </div>
                <div class="col-lg-3">
                    <label for="">คำนำหน้า</label>
                    <select name="prefix" class="form-control" id="">
                        <?php
                        $list = \backend\helpers\Prefixname::asArrayObject();
                        for($i=0;$i<=count($list)-1;$i++):
                            ?>
                            <option value="<?=$list[$i]['id']?>"><?=$list[$i]['name']?></option>
                        <?php endfor;?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <?= $form->field($model, 'card_id')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'line')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <?= $form->field($model, 'facebook')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-3">
                    <label>กลุ่มลูกค้า</label>
                    <select name="customer_group" class="form-control" id="">

                        <?php foreach ($custgroup as $value):?>
                            <?php
                            $select = '';
                            if($model->customer_group_id == $value->id){$select = "selected";}
                            ?>
                            <option value="<?=$value->id?>" <?=$select?>><?=$value->name?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label for="">ประเภทจัดส่ง</label>
                    <select name="delivery_type" class="form-control" id="">
                        <?php
                        $list = \backend\helpers\DeliveryType::asArrayObject();
                        for($i=0;$i<=count($list)-1;$i++):
                            ?>
                            <?php
                            $select = '';
                            if($list[$i]['id'] == $model->delivery_type){$select = 'selected';}
                            ?>
                            <option value="<?=$list[$i]['id']?>" <?=$select?>><?=$list[$i]['name']?></option>
                        <?php endfor;?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">


                <div class="col-lg-3">
                    <?php echo $form->field($model, 'status')->widget(Switchery::className(),['options'=>['label'=>'','class'=>'form-control']])->label('สถานะ') ?>

                </div>
            </div>

            <hr />
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group" style="margin-top: -10px">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name"><?=Yii::t('app','ที่อยู่')?>
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <textarea name="address" id="address" class="form-control" cols="30" rows="2"><?=$model_address_plant?trim($model_address_plant->address):'';?></textarea>
                            <?php //echo $form->field($model_address_plant?$model_address_plant:$model_address, 'address')->textarea(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group" style="margin-top: -10px">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name"><?=Yii::t('app','ถนน')?>
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="text" class="form-control" name="street" value="<?=$model_address_plant?$model_address_plant->street:''?>">
                            <?php //echo $form->field($model_address_plant?$model_address_plant:$model_address, 'street')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group" style="margin-top: -10px">
                        <label class="control-label col-lg-12" for="first-name"><?=Yii::t('app','ตำบล')?>
                        </label>
                        <div class="col-lg-12">
                            <?php
                               $disabled = '';
                               if($model->isNewRecord){
                                  $disabled = 'disabled';
                               }
                            ?>
                            <select name="select_district" class="form-control" id="district" <?=$disabled?>>
                                <?php if($model->isNewRecord):?>
                                    <option value=""></option>
                                <?php else:?>
                                    <?php foreach ($dist as $value):?>
                                        <?php
                                        $select = '';
                                        $dis_id = $model_address_plant?$model_address_plant->district_id:0;
                                        if($value->DISTRICT_ID ==  $dis_id){$select = 'selected';}
                                        ?>
                                        <option value="<?=$value->DISTRICT_ID?>" <?=$select;?>><?=$value->DISTRICT_NAME?></option>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group" style="margin-top: -10px">
                        <label class="control-label col-lg-12" for="first-name"><?=Yii::t('app','อำเภอ')?>
                        </label>
                        <div class="col-lg-12">
                            <?php
                            $disabled = '';
                            if($model->isNewRecord){
                                $disabled = 'disabled';
                            }
                            ?>
                            <select name="select_city" onchange="findDistrict($(this))" class="form-control" id="city" <?=$disabled?>>
                                <?php if($model->isNewRecord):?>
                                    <option value=""></option>
                                <?php else:?>
                                    <?php foreach ($amp as $value):?>
                                        <?php
                                        $select = '';
                                        $city_id = $model_address_plant?$model_address_plant->city_id:0;
                                        if($value->AMPHUR_ID ==  $city_id){$select = 'selected';}
                                        ?>
                                        <option value="<?=$value->AMPHUR_ID?>" <?=$select?>><?=$value->AMPHUR_NAME?></option>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group" style="margin-top: -10px">
                        <label class="control-label col-lg-12" for="first-name"><?=Yii::t('app','จังหวัด')?>
                        </label>
                        <div class="col-lg-12">
                            <select name="select_province" onchange="findCity($(this))" class="form-control" id="">
                                <?php foreach ($prov as $value):?>
                                    <?php
                                    $select = '';
                                    $prov_id = $model_address_plant?$model_address_plant->province_id:0;
                                    if($value->PROVINCE_ID ==  $prov_id){$select = 'selected';}
                                    ?>
                                    <option value="<?=$value->PROVINCE_ID?>" <?=$select?>><?=$value->PROVINCE_NAME?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group" style="margin-top: -10px">
                        <label class="control-label col-lg-12" for="first-name"><?=Yii::t('app','รหัสไปรษณีย์')?>
                        </label>
                        <div class="col-lg-12">
                            <?php if($model_address_plant):?>
                                <input type="text" name="zipcode" class="form-control" id="zipcode" value="<?=$model_address_plant->zipcode?>" readonly>
                                <?php //echo $form->field($model_address_plant, 'zipcode')->textInput(['class'=>'form-control','id'=>'zipcode','readonly'=>'readonly'])->label(false) ?>
                            <?php else:?>
                                <input type="text" name="zipcode" class="form-control" id="zipcode" value="" readonly>
                                <?php //echo $form->field($model_address, 'zipcode')->textInput(['class'=>'form-control','id'=>'zipcode','readonly'=>'readonly'])->label(false) ?>
                            <?php endif;?>

                        </div>
                    </div>
                </div>
            </div>
            <hr/>


            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">อัพโหลดรูปภาพ</h4>
                            <label for="input-file-max-fs"></label>
                            <input type="file" name="imagefile[]" id="input-file-max-fs" multiple class="dropify" data-max-file-size="2M" />

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <?php if(!$model->isNewRecord): ?>
                        <div class="row">
                            <?php foreach ($modelfile as $value):?>

                                <div class="col-xs-6 col-md-3">
                                    <div class="card">
                                        <img class="card-img-top img-responsive" src="../../backend/web/uploads/images/<?=$value->name?>" alt="Card image cap">
                                        <div class="card-body">
                                            <a href="#" onclick="removepic($(this));" class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>

                                <?php //echo Html::img("../../frontend/web/img/screenshots/".$value->filename,['width'=>'10%','class'=>'thumbnail']) ?>
                            <?php endforeach;?>
                        </div>

                    <?php endif;?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">

                                        <div class="card">
                                            <div class="card-body">
                    <h4 class="card-title">อัพโหลดเอกสาร</h4>
                    <label for="input-file-max-fs"></label>
                    <input type="file" name="docfile[]" id="input-file-max-fs" multiple class="dropify" data-max-file-size="2M" />
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ชื่อไฟล์</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(count($modeldoc)):?>
                                            <?php $i = 0;?>
                                            <?php foreach ($modeldoc as $value):?>
                                                <?php $i +=1;?>
                                                <tr>
                                                    <td><?=$i?></td>
                                                    <td>
                                                        <?=$value->name?>
                                                    </td>
                                                    <td>
                                                        <a href="uploads/documents/<?=$value->name?>" class="btn btn-secondary" target="_blank"><i class="fa fa-print"></i></a>
                                                        <a href="#" class="btn btn-danger remove-file" onclick="removefile($(this))"><i class="fa fa-trash"></i></a>
                                                    </td>

                                                </tr>
                                            <?php endforeach;?>
                                        <?php else:?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <?php endif;?>
                                        </tbody>


                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                </div>
                                </div>
            </div>


            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
<?php
$url_to_del_pic = Url::to(['customer/deletepic'],true);
$url_to_del_file = Url::to(['customer/deletefile'],true);
$js =<<<JS

 var item_list = [];
 var bucket_list = [];

  $(function() {
       $(".select_item").val('$old_item');
       $(".select_bucket").val('$old_bucket');
       item_list = [$(".select_item").val()];
       bucket_list = [$(".select_bucket").val()];
       
       // $("input:textarea").each(function(){
       //    $(this).val($(this).val().trim()); 
       // });
       
  });
  ! function(window, document, $) {
        "use strict";
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(), $(".skin-square input").iCheck({
            checkboxClass: "icheckbox_square-green",
            radioClass: "iradio_square-green"
        }), $(".touchspin").TouchSpin(), $(".switchBootstrap").bootstrapSwitch();
    }(window, document, jQuery);
  function removefile(e){
    if(confirm("ต้องการลบไฟล์นี้ใช่หรือไม่")){
        $.ajax({
           'type':'post',
           'dataType':'html',
           'url':"$url_to_del_file",
           'data': {'file_id':e.closest("tr").find("td:eq(1)").text(),'cus_id':$(".cur_cus").val()},
           'success': function(data) {
             //  alert(data);
             location.reload();
           }
        });
    }
  }
  function removepic(e){
   // alert(e.attr("data-var"));return;
  // alert('$url_to_del_pic');
    if(confirm("ต้องการลบรูปภาพนี้ใช่หรือไม่")){
        $.ajax({
           'type':'post',
           'dataType':'html',
           'url':"$url_to_del_pic",
           'data': {'pic_id':e.attr("data-var")},
           'success': function(data) {
             location.reload();
           }
        });
    }
  }
  function enableqty(e){
      if(e.prop("checked")){
          e.closest("tr").find(".line_qty").removeAttr('disabled');
          e.closest("tr").find(".line_qty").val(1);
          
          e.closest("tr").find(".line_price").removeAttr('disabled');
          e.closest("tr").find(".line_price").val(1);
          
          item_list.push(e.val());
      }else{
          e.closest("tr").find(".line_qty").prop('disabled','disabled').val('');
          e.closest("tr").find(".line_price").prop('disabled','disabled').val('');
          item_list.splice(item_list.indexOf(e.val() ), 1);
          
      }
      //alert(item_list);
     $(".select_item").val(item_list);

  }
  function enableqty2(e){
      if(e.prop("checked")){
          e.closest("tr").find(".line_qty").removeAttr('disabled');
          e.closest("tr").find(".line_qty").val(1);
          bucket_list.push(e.val());
      }else{
          e.closest("tr").find(".line_qty").prop('disabled','disabled').val('');
          bucket_list.splice(bucket_list.indexOf(e.val() ), 1);
          
      }
      //alert(item_list);
   
     $(".select_bucket").val(bucket_list);
  }
JS;

$this->registerJs($js,static::POS_END);

?>
