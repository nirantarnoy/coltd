<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii2assets\fullscreenmodal\FullscreenModal;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Sale */
/* @var $form yii\widgets\ActiveForm */
$this->registerCss('
    #imaginary_container{
        margin-top:1%; /* Don\'t copy this */
    }
    .stylish-input-group .input-group-addon{
        background: white !important; 
    }
    .stylish-input-group .form-control{
        border-right:0; 
        box-shadow:0 0 0; 
        border-color:#ccc;
    }
    .stylish-input-group button{
        border:0;
        background:transparent;
    }
');


//$wh = \backend\models\Warehouse::find()->all();

?>

<div class="sale-form">
    <div class="panel panel-headline">
        <div class="panel-body">
            <div class="form-group pull-right">
                <?= Html::Button("<i class='fa fa-list-alt'></i> picking list", ['class' => 'btn btn-info btn-gen-packing']) ?>
                <?php //echo Html::Button("<i class='fa fa-check-circle'></i> สร้างเอกสารเรียกเก็บเงิน", ['class' => 'btn btn-danger btn-gen-invoice']) ?>
            </div>
            <?php $form = ActiveForm::begin(); ?>
            <input type="hidden" class="remove-list" name="removelist" value="">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-3">
                            <?= $form->field($model, 'sale_no')->textInput(['maxlength' => true,'readonly'=>'readonly','value'=>$model->isNewRecord?$runno:$model->sale_no]) ?>
                        </div>
                        <div class="col-lg-3">
                            <?php $model->require_date = $model->isNewRecord?date('d/m/Y'):date('d/m/Y',$model->require_date);?>
                            <?= $form->field($model, 'require_date')->widget(DatePicker::className()) ?>
                        </div>
                        <div class="col-lg-3">
                            <?= $form->field($model, 'customer_id')->widget(Select2::className(),[
                                'data'=>ArrayHelper::map(\backend\models\Customer::find()->all(),'id','name'),
                                'options'=>[
                                    'placeholder'=>'เลือกลูกค้า'
                                ],
                                'pluginOptions'=>[
                                    'allowClear'=>true
                                ]
                            ]) ?>
                        </div>
                        <div class="col-lg-3">
                            <?= $form->field($model, 'customer_ref')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
<!--                        <div class="col-lg-3">-->
<!--                            --><?php ////echo $form->field($model, 'delvery_to')->textInput() ?>
<!--                        </div>-->
                        <div class="col-lg-3">
                            <?= $form->field($model, 'currency')->widget(Select2::className(),[
                                'data'=>ArrayHelper::map(\backend\helpers\Currency::asArrayObject(),'id','name'),
                                'options'=>[
                                    'placeholder'=>'เลือกสกุลเงิน'
                                ],
                                'pluginOptions'=>[
                                    'allowClear'=>true
                                ]
                            ]) ?>
                        </div>
                        <div class="col-lg-3">
                            <?= $form->field($model, 'status')->textInput(['value'=>\backend\helpers\SaleStatus::getTypeById($model->status),'readonly'=>'readonly']) ?>
                        </div>
                        <div class="col-lg-3">
                            <?= $form->field($model, 'quotation_id')->textInput(['value'=>\backend\models\Quotation::findNum($model->quotation_id),'readonly'=>'readonly']) ?>
                        </div>
                    </div>

                </div>
                <div class="col-lg-3">

                    <?= $form->field($model, 'note')->textarea(['maxlength' => true]) ?>


                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-quotation">
                        <thead>
                        <tr style="background-color: #00afe1;color: #ffffff">
                            <th style="width: 5%">#</th>
                            <th>รหัสสินค้า</th>
                            <th>รายละเอียด</th>
                            <th style="width: 10%">จำนวน</th>
                            <th style="width: 10%">ทุน</th>
                            <th>ราคา</th>
                            <th>รวม</th>
                            <th>-</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php if($model->isNewRecord):?>
                            <tr>
                                <td style="vertical-align: middle;text-align: center">

                                </td>
                                <td>
                                    <input type="hidden" class="productid" name="productid[]">
                                    <input type="text" class="form-control productcode" name="prodcode[]" value="" onchange="itemchange($(this));" ondblclick="showfind($(this))">
                                </td>
                                <td>
                                    <input type="text" class="form-control productname" name="prodname[]" value="" readonly>
                                </td>
                                <td>
                                    <input type="number" min="0" class="form-control line_qty" name="qty[]" value="" onchange="cal_num($(this))">
                                </td>
                                <td>
                                    <input style="text-align: right" type="text" class="form-control line_cost" name="cost[]" value="" readonly>
                                </td>
                                <td>
                                    <input style="text-align: right" type="text" class="form-control line_price" name="price[]" value="" onchange="cal_num($(this));">
                                </td>
                                <td>
                                    <input style="text-align: right" type="text" class="form-control line_total" name="linetotal[]" value="" readonly>
                                </td>
                                <td>
                                    <div class="btn btn-sm btn-danger btn-removeline" onclick="return removeline($(this));"><i class="fa fa-trash-o"></i></div>
                                </td>
                            </tr>
                        <?php else:?>
                            <?php if(count($modelline) >0):?>
                                <?php $i=0;?>
                                <?php foreach ($modelline as $value):?>
                                    <?php $i+=1;?>
                                    <tr data-var="<?=$value->id?>">
                                        <td style="vertical-align: middle;text-align: center">
                                            <?=$i?>
                                        </td>
                                        <td>
                                            <input type="hidden" class="productid" name="productid[]" value="<?=$value->product_id?>">
                                            <input type="text" class="form-control productcode" name="prodcode[]" value="<?=\backend\models\Product::findEng($value->product_id)?>" onchange="itemchange($(this));" ondblclick="showfind($(this))">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control productname" name="prodname[]" value="<?=\backend\models\Product::findName($value->product_id)?>" readonly>
                                        </td>
                                        <td>
                                            <input type="number" min="0" class="form-control line_qty" name="qty[]" value="<?=$value->qty?>" onchange="cal_num($(this));">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control line_cost" name="cost[]" value="<?=\backend\models\Product::findProductinfo($value->product_id)!=null?\backend\models\Product::findProductinfo($value->product_id)->cost:0?>" readonly>
                                        </td>
                                        <td>
                                            <input style="text-align: right" type="text" class="form-control line_price" name="price[]" value="<?=$value->price?>" onchange="cal_num($(this));">
                                        </td>
                                        <td>
                                            <input style="text-align: right" type="text" class="form-control line_total" name="linetotal[]" value="<?=$value->price * $value->qty?>" readonly>
                                        </td>
                                        <td>
                                            <div class="btn btn-sm btn-danger btn-removeline" onclick="return removeline($(this));"><i class="fa fa-trash-o"></i></div>
                                        </td>
                                    </tr>

                                <?php endforeach;?>
                            <?php else:?>
                                <tr>
                                    <td style="vertical-align: middle;text-align: center">

                                    </td>
                                    <td>
                                        <input type="hidden" class="productid" name="productid[]">
                                        <input type="text" class="form-control productcode" name="prodcode[]" value="" onchange="itemchange($(this));" ondblclick="showfind($(this))">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control productname" name="prodname[]" value="" readonly>
                                    </td>
                                    <td>
                                        <input type="number" min="0" class="form-control line_qty" name="qty[]" value="" onchange="cal_num($(this));">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control line_cost" name="cost[]" value="" readonly>
                                    </td>
                                    <td>
                                        <input style="text-align: right" type="text" class="form-control line_price" name="price[]" value="" onchange="cal_num($(this));">
                                    </td>
                                    <td>
                                        <input style="text-align: right" type="text" class="form-control line_total" name="linetotal[]" value="" readonly>
                                    </td>
                                    <td>
                                        <div class="btn btn-sm btn-danger btn-removeline" onclick="return removeline($(this));"><i class="fa fa-trash-o"></i></div>
                                    </td>
                                </tr>
                            <?php endif;?>

                        <?php endif;?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5"></td>
                            <td style="text-align: right;font-weight: bold">ยอดรวม</td>
                            <td style="text-align: right;font-weight: bold" class="total-sum">0.00</td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="btn btn-default btn-addline"><i class="fa fa-plus-circle"></i> เพิ่มรายการ</div>
                </div>
            </div>

            <hr />

            <div class="form-group pull-right">
                <?= Html::submitButton("<i class='fa fa-save'></i> บันทึก", ['class' => 'btn btn-success']) ?>
               </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
<div class="panel">
    <div class="panel-heading">
        <h3>ประวัติ picking</h3>
    </div>
    <div class="panel-body">
        <div class="panel-group" id="accordion">
            <?php if(!$model->isNewRecord):?>
                <?php if(count($modelpick) > 0):?>
                    <?php $i = 0;?>
                    <?php foreach ($modelpick as $value):?>
                        <?php $i+=1;?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$i?>">
                                        <?=$value->picking_no?> <label class="label label-success"><?=date('d/m/Y',$value->trans_date)?></label></a> <span class="pull-right"><div class="btn <?=$value->geninv?'btn-success':'btn-danger'?>"><i class='fa fa-check-circle'></i>  ออกเอกสารเก็บเงิน</div></span>
                                </h4>

                            </div>
                            <div id="collapse<?=$i?>" class="panel-collapse collapse out">
                                <div class="panel-body">
                                    <table>
                                        <?php foreach ($modelpickline as $val):?>
                                        <?php if($value->id == $val->picking_id):?>
                                        <tr>
                                            <td>1</td>
                                            <td><?=$val->product_id?></td>
                                            <td><?=$val->qty?></td>
                                            <td></td>
                                        </tr>
                                        <?php endif;?>
                                        <?php endforeach;?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                <?php endif;?>
            <?php endif;?>


        </div>
    </div>
</div>
<div id="findModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="row">
                    <div class="col-sm-6">
                        <div id="imaginary_container">
                            <div class="input-group stylish-input-group">
                                <input type="text" class="form-control"  placeholder="ค้นหาสินค้า" >
                                <span class="input-group-addon">
                                        <button type="submit">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-body">
                <input type="hidden" name="line_qc_product" class="line_qc_product" value="">
                <table class="table table-bordered table-striped table-list">
                    <thead>
                    <tr>
                        <th>รหัสสินค้า</th>
                        <th>รายละเอียด</th>
                        <th style="text-align: center">เลือก</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close text-danger"></i> ปิดหน้าต่าง</button>
            </div>
        </div>

    </div>
</div>


<div id="pickModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="text-primary"><i class="fa fa-plus-circle"></i> ทำรายการ picking list</h3>
            </div>
            <div class="modal-body">
                <form id="form-picking" action="<?=Url::to(['sale/createpicking'],true)?>" method="post">
                    <input type="hidden" name="sale_id" class="sale-id" value="">
                    <table class="table table-bordered table-striped table-picking">
                        <thead>
                        <tr>
                            <th>รายละเอียด</th>
                            <th>จำนวน</th>
                            <th>คลังสินค้า</th>
                            <th>เลขที่ใบนำเข้า</th>
                            <th>เลขที่ใบอนุญาต</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-save-picking"><i class="fa fa-save"></i> บันทึกรายการ</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close text-danger"></i> ปิดหน้าต่าง</button>
            </div>
        </div>

    </div>
</div>

<?php
$url_to_find = Url::to(['quotation/finditem'],true);
$url_to_find_wh = Url::to(['sale/findwarehouse'],true);
$url_to_find_permit = Url::to(['sale/findpermit'],true);
$url_to_find_transport = Url::to(['sale/findtransport'],true);
$url_to_createinvoice = Url::to(['sale/createinvoice'],true);
$js =<<<JS
 var currow = 0;
 var  removelist = [];
 var quote = '$model->id';
 $(function(){
     cal_all();
     $(".btn-gen-invoice").click(function(){
        if(confirm("ต้องการสร้างใบเรียกเก็บเงินใช่หรือไม่")){
            $.ajax({
              'type':'post',
              'dataType': 'json',
              'url': "$url_to_createinvoice",
              'data': {'sale_id': quote },
              'success': function(data) {
                  
              }
            });
        } 
     });
     $(".btn-addline").click(function(){
          var tr = $(".table-quotation tbody tr:last");
          
          if(tr.closest("tr").find(".productcode").val() == ""){
              tr.closest("tr").find(".productcode").css({'border-color': 'red'});
              tr.closest("tr").find(".productcode").focus();
              return;
          }else{
              tr.closest("tr").find(".productcode").css({'border-color': ''});
          }
          
          var linenum = 0;
          var clone = tr.clone();
          clone.find(":text").val("");
          clone.attr("data-var","");
          
          clone.find(".line_qty,.line_price").on("keypress",function(event){
                $(this).val($(this).val().replace(/[^0-9\.]/g,""));
                if((event.which != 46 || $(this).val().indexOf(".") != -1) && (event.which <48 || event.which >57)){event.preventDefault();}
        });
          
          tr.after(clone);
          
           $(".table-quotation tbody tr").each(function(){
             linenum+=1;
             $(this).closest("tr").find("td:eq(0)").text(linenum);
           });
    });
     
    $(".line_qty,.line_cost,.line_price").on("keypress",function(event){
       $(this).val($(this).val().replace(/[^0-9\.]/g,""));
       if((event.which != 46 || $(this).val().indexOf(".") != -1) && (event.which <48 || event.which >57)){event.preventDefault();}
    });
    
    
    $(".btn-gen-packing").click(function(){
        $(".table-picking tbody tr").remove();
       
        $(".table-quotation tbody tr").each(function(){
           
            var prod = $(this).find(".productid").val();
            var wselect = '';
            var perselect = '';
            var transportselect = '';
            
            $.ajax({
              'type':'post',
              'dataType': 'html',
              'url': "$url_to_find_wh",
              'async': false,
              'data': {'prod': prod},
              'success': function(data) {
                  wselect="<select name='picking_wh[]' class='form-control'>"+data+"</select>";
                 // alert(data);
              }
            });
            $.ajax({
              'type':'post',
              'dataType': 'html',
              'url': "$url_to_find_permit",
              'async': false,
              'data': {'prod': prod},
              'success': function(data) {
                  perselect="<select name='picking_permit[]' class='form-control'>"+data+"</select>";
                 // alert(data);
              }
            });
            $.ajax({
              'type':'post',
              'dataType': 'html',
              'url': "$url_to_find_transport",
              'async': false,
              'data': {'prod': prod},
              'success': function(data) {
                  transportselect="<select name='picking_transport[]' class='form-control'>"+data+"</select>";
                 // alert(data);
              }
            });
            
            
            var xrow = "<tr><td>"+$(this).find(".productcode").val()+"</td><td>"+$(this).find(".line_qty").val()+"</td><td>"+wselect+"</td><td>"+transportselect+"</td><td>"+perselect+"</td></tr>";
            $(".table-picking tbody").append(xrow);
        });
         $("#pickModal").modal("show").find(".sale-id").val("$model->id");
    });
    
    $(".btn-picking-line").click(function(){
        
    });
    $(".btn-save-picking").click(function(){
       $("form#form-picking").submit();
    });
 });

 function itemchange(e) {
   if(e.val() !=""){
      
        e.css({'border-color': ''});
   }else{
        e.css({'border-color': 'red'});
   }
 }
 function removeline(e){
     if(confirm("ต้องการลบรายการนี้ใช่หรือไม่?")){
         if(e.parent().parent().attr("data-var") !=''){
             removelist.push(e.parent().parent().attr("data-var"));
         }  
         alert(removelist);
         $(".remove-list").val(removelist);
         if($(".table-quotation tbody tr").length == 1){
             $(".table-quotation tbody tr").each(function(){
                 $(this).find(":text").val("");
             });
         }else{
            
           e.parent().parent().remove();
           cal_linenum();
         }
         cal_all();
     }
 }
  function cal_linenum(){
   var xline = 0;
  $(".table-quotation tbody tr").each(function(){
         xline+=1;
         $(this).closest("tr").find("td:eq(0)").text(xline);
      });
 }
 function showfind(e){
     currow = 0;
     currow = e.parent().parent().index();
   //  alert(currow);
     $("#findModal").modal("show");
     $.ajax({
              'type':'post',
              'dataType': 'json',
              'url': "$url_to_find",
              'data': {'txt': "*"},
              'success': function(data) {
                // alert(data);return;
                 if(data.length == 0){
                      $(".table-list").hide();
                     $(".modal-error").show();
                 }else{
                     $(".modal-error").hide();
                     $(".table-list").show();
                     var html = "";
                     for(var i =0;i<=data.length -1;i++){
                         html +="<tr ondblclick='getitem($(this));'><td style='vertical-align: middle'>"+
                         data[i]['engname']+"</td><td style='vertical-align: middle'>"+
                         data[i]['name']+"<input type='hidden' class='recid' value='"+data[i]['id']+"'/>" +
                          "<input type='hidden' class='prodcost' value='"+data[i]['cost']+"'/>" +
                          "<input type='hidden' class='prodprice' value='"+data[i]['price']+"'/>" +
                           "</td><td style='vertical-align: middle;text-align: center'><div class='btn btn-info btn-sm' onclick='getitem($(this));'>เลือก</div></td></tr>"
                     }
                     $(".table-list tbody").html(html);
                     
                 }
              }
            });
 }
 function cal_num(e){
     var qty = e.closest("tr").find(".line_qty").val();
     var price = e.closest("tr").find(".line_price").val();
     
     if(qty == ""){qty = 0;}
     if(price == ""){price = 0;}
     
     var total = parseFloat(qty).toFixed(2) * parseFloat(price).toFixed(2);
     e.closest("tr").find(".line_total").val("");
     e.closest("tr").find(".line_total").val(parseFloat(total).toFixed(2));
     
     cal_all();
   }
 
 function getitem(e){
    var prodcode = e.closest("tr").find("td:eq(0)").text();
    var prodname = e.closest("tr").find("td:eq(1)").text();
    var prodid = e.closest("tr").find(".recid").val();
    var prodcost = e.closest("tr").find(".prodcost").val();
    var prodprice = e.closest("tr").find(".prodprice").val();
    $(".table-quotation tbody tr").each(function() {
        if($(this).closest('tr').find(".productcode").val() == prodcode){
          alert("รายการสินค้านี้ซ้ำ");return false;   
        }
        if($(this).index() == currow){
              $(this).closest('tr').find(".productcode").val(prodcode);
              $(this).closest('tr').find(".productname").val(prodname);
              $(this).closest('tr').find(".productid").val(prodid);
              $(this).closest('tr').find(".line_qty").val(1);
              $(this).closest('tr').find(".line_cost").val(prodcost);
              $(this).closest('tr').find(".line_price").val(prodprice);
        }
        cal_num($(this));
    });
    ;
    $("#findModal").modal("hide");
 }
 function cal_all(){
      var totalall = 0;
      $(".table-quotation tbody tr").each(function() {
          var linetotal = $(this).closest("tr").find(".line_total").val();
          
          if(linetotal == ''){linetotal = 0;}
          
          totalall = parseFloat(totalall) + parseFloat(linetotal);
      });
      $(".total-sum").text(parseFloat(totalall).toFixed(2));
 }
 
JS;
$this->registerJs($js,static::POS_END);
?>

