<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Quotation */
/* @var $form yii\widgets\ActiveForm */

$has_so = \backend\models\Sale::find()->where(['quotation_id'=>$model->id])->one();

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
    
     .popover1 {top: 10px; left: 10px; position: relative;}
      #big { z-index: 999; position:absolute; text-align:center; padding:2px; background-color:#fff; border:1px solid #999; }
      #big img { height: 250px; }
    
');

?>

<div class="quotation-form">
    <div class="panel panel-headline">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>
            <input type="hidden" class="remove-list" name="removelist" value="">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-3">
                            <?= $form->field($model, 'quotation_no')->textInput(['maxlength' => true,'readonly'=>'readonly','value'=>$model->isNewRecord?$runno:$model->quotation_no]) ?>
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
<!--                       <div class="col-lg-3">-->
<!--                           --><?php ////echo $form->field($model, 'delvery_to')->textInput() ?>
<!--                       </div>-->
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
                           <?= $form->field($model, 'status')->textInput(['value'=>\backend\helpers\QuotationStatus::getTypeById($model->status)]) ?>
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
                                <th style="width: 5%">รูป</th>
                                <th>รหัสสินค้า</th>
                                <th>รายละเอียด</th>
                                <th>ปริมาณ/ลัง</th>
                                <th>ลิตร/ขวด</th>
                                <th>%</th>
                                <th style="width: 10%">จำนวน</th>
                                <th style="width: 10%">origin</th>
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
                                <td style="vertical-align: middle">
                                    <i class="fa fa-image"></i>
                                </td>
                                <td>
                                    <input type="hidden" class="productid" name="productid[]">
                                    <input type="text" class="form-control productcode" name="prodcode[]" value="" onchange="itemchange($(this));" ondblclick="showfind($(this))">
                                </td>
                                <td>
                                    <input type="text" class="form-control productname" name="prodname[]" value="" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control line_packper" value="" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control line_litre" value="" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control line_percent" value="" readonly>
                                </td>
                                <td>
                                    <input type="number" min="0" class="form-control line_qty" name="qty[]" value="" onchange="cal_num($(this))">
                                </td>
                                <td>
<!--                                    <input style="text-align: right" type="text" class="form-control line_cost" name="cost[]" value="" readonly>-->
                                    <input style="text-align: right" type="text" class="form-control line_origin" name="origin[]" value="" readonly>
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
                                        <td style="vertical-align: middle;text-align: left">
                                            <?php
                                               if(\backend\models\Product::findImg($value->product_id) == ''):?>
                                                <i class="fa fa-image"></i>
                                                  <?php else:?>
                                                   <?=Html::img('../web/uploads/images/'.\backend\models\Product::findImg($value->product_id),['style'=>'width: 100%;left: 0px;top: 0px','class'=>'popover1'])?>
                                                  <?php endif;?>
                                        </td>
                                        <td>
                                            <input type="hidden" class="productid" name="productid[]" value="<?=$value->product_id?>">
                                            <input type="text" class="form-control productcode" name="prodcode[]" value="<?=\backend\models\Product::findCode($value->product_id)?>" onchange="itemchange($(this));" ondblclick="showfind($(this))">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control productname" name="prodname[]" value="<?=\backend\models\Product::findName($value->product_id)?>" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control line_packper" value="" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control line_litre" value="" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control line_percent" value="" readonly>
                                        </td>
                                        <td>
                                            <input type="number" min="0" class="form-control line_qty" name="qty[]" value="<?=$value->qty?>" onchange="cal_num($(this));">
                                        </td>
                                        <td>
<!--                                            <input type="text" class="form-control line_cost" name="cost[]" value="" readonly>-->
                                            <input type="text" class="form-control line_origin" name="origin[]" value="<?=\backend\models\Product::findProductinfo($value->product_id)!=null?\backend\models\Product::findProductinfo($value->product_id)->origin:''?>" readonly>
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
                                    <td style="vertical-align: middle">
                                        <i class="fa fa-image"></i>
                                    </td>
                                    <td>
                                        <input type="hidden" class="productid" name="productid[]">
                                        <input type="text" class="form-control productcode" name="prodcode[]" value="" onchange="itemchange($(this));" ondblclick="showfind($(this))">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control productname" name="prodname[]" value="" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control line_packper" value="" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control line_litre" value="" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control line_percent" value="" readonly>
                                    </td>
                                    <td>
                                        <input type="number" min="0" class="form-control line_qty" name="qty[]" value="" onchange="cal_num($(this));">
                                    </td>
                                    <td>
<!--                                        <input style="text-align: right" type="text" class="form-control line_cost" name="cost[]" value="" readonly>-->
                                        <input style="text-align: right" type="text" class="form-control line_origin" name="origin[]" value="" readonly>
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
                            <td colspan="9"></td>
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

            <div class="pull-left">
                <?php if($has_so):?>
                    <div style="border: 1px solid orange;width: 300px;text-align: center;border-radius: 25px;padding: 5px 0px 5px 0px;">
                        <?php echo "เลขที่ใบสั่งซื้อ ".$has_so->sale_no;?>
                    </div>
                <?php endif;?>
            </div>
            <div class="form-group pull-right">
                <?= Html::submitButton("<i class='fa fa-save'></i> บันทึก", ['class' => 'btn btn-success']) ?>
                <?php if(!$model->isNewRecord):?>
                    <?= Html::Button("<i class='fa fa-print'></i> พิมพ์", ['class' => 'btn btn-warning btn-quote-print']) ?>
                    <?php if(!$has_so):?>
                        <?= Html::Button("<i class='fa fa-random'></i> เปิดออเดอร์", ['class' => 'btn btn-primary btn-firm-sale']) ?>
                    <?php endif;?>
                <?php endif;?>
            </div>

            <?php ActiveForm::end(); ?>
            <form id="form-quote" target="_blank" method="post" action="<?=Url::to(['quotation/bill','id'=>$model->id],true)?>"></form>
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
                                    <input type="text" class="form-control search-item"  placeholder="ค้นหาสินค้า" >
                                    <span class="input-group-addon">
                                        <button type="submit" class="btn-search-submit">
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
                            <th>Origin</th>
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
<!--<div id="hover-div" display="none">-->
<!--    <img class="popover1" style="height: 100px;" src="http://transolid.com/assets/images/colors/previews/prev_sorrento_coast.jpg" title="some title text"/>-->
<!--</div>-->
<?php
$url_to_find = Url::to(['quotation/finditem'],true);
$url_to_firm = Url::to(['quotation/firmorder'],true);
$url_to_find_product = Url::to(['product/searchitem'],true);
$js =<<<JS
 var currow = 0;
 var  removelist = [];
 var quote = '$model->id';
 $(function(){
     cal_all();
     $(".btn-firm-sale").click(function(){
        if(confirm("ต้องการเปิดใบออเดอร์ใช่หรือไม่")){
            $.ajax({
              'type':'post',
              'dataType': 'json',
              'url': "$url_to_firm",
              'data': {'quotation_id': quote },
              'success': function(data) {
                  
              }
            });
        } 
     });
     $(".btn-quote-print").click(function(){
         //alert($("#form-quote").attr("action"));
        $("form#form-quote").submit(); 
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
          clone.find("td:eq(1)").text("");
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
    
    
    $('.popover1').on({
      mousemove: function(e) {
          $(this).next('#big').css({
              top: e.pageY - 400 - 25, // height of image and title area plus some
       //       left: e.pageX + -120
              left: e.pageX + -250
          });
      },
      mouseenter: function() {
          var big = $('<img />', {'class': 'big_img1', src: this.src}),
              title = $('<div class="title"/>').html(this.title),
              frame = $('<div id="big" />');

          frame.append(big).append(title);

          $(this).after(frame);
      },
      mouseleave: function() {
          $('#big').remove();
      }
  });
    
    $(".btn-search-submit").click(function(){
      var textsearch = $(".search-item").val();
      $.ajax({
              'type':'post',
              'dataType': 'json',
              'url': "$url_to_find_product",
              'data': {'txt': textsearch},
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
                          "<input type='hidden' class='prodnet' value='"+data[i]['netweight']+"'/>" +
                          "<input type='hidden' class='prodgross' value='"+data[i]['grossweight']+"'/>" +
                          "<input type='hidden' class='prodorigin' value='"+data[i]['origin']+"'/>" +
                          "<input type='hidden' class='prodgeo' value='"+data[i]['geolocation']+"'/>" +
                          "<input type='hidden' class='unitfactor' value='"+data[i]['unit_factor']+"'/>" +
                          "<input type='hidden' class='volumn' value='"+data[i]['volumn']+"'/>" +
                          "<input type='hidden' class='volumn_content' value='"+data[i]['volumn_content']+"'/>" +
                           "</td>"+
                           "<td>"+data[i]['origin']+"</td>"+
                           "<td style='vertical-align: middle;text-align: center'><div class='btn btn-info btn-sm' onclick='getitem($(this));'>เลือก</div></td></tr>"
                     }
                     $(".table-list tbody").html(html);
                     
                 }
              }
            });
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
        // alert(removelist);
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
                          "<input type='hidden' class='prodnet' value='"+data[i]['netweight']+"'/>" +
                          "<input type='hidden' class='prodgross' value='"+data[i]['grossweight']+"'/>" +
                          "<input type='hidden' class='prodorigin' value='"+data[i]['origin']+"'/>" +
                          "<input type='hidden' class='prodgeo' value='"+data[i]['geolocation']+"'/>" +
                          "<input type='hidden' class='unitfactor' value='"+data[i]['unit_factor']+"'/>" +
                          "<input type='hidden' class='volumn' value='"+data[i]['volumn']+"'/>" +
                          "<input type='hidden' class='volumn_content' value='"+data[i]['volumn_content']+"'/>" +
                           "</td>"+
                           "<td>"+data[i]['origin']+"</td>"+
                           "<td style='vertical-align: middle;text-align: center'><div class='btn btn-info btn-sm' onclick='getitem($(this));'>เลือก</div></td></tr>"
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
    var prodorigin = e.closest("tr").find("td:eq(2)").text()=="null"?'':e.closest("tr").find("td:eq(2)").text();
    var prodid = e.closest("tr").find(".recid").val();
    var prodcost = e.closest("tr").find(".prodcost").val();
    var prodprice = e.closest("tr").find(".prodprice").val();
    var unitfactor = e.closest("tr").find(".unitfactor").val();
    var volumn = e.closest("tr").find(".volumn").val();
    var volumn_content = e.closest("tr").find(".volumn_content").val();
    
    //alert(volumn);
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
              $(this).closest('tr').find(".line_origin").val(prodorigin);
              $(this).closest('tr').find(".line_price").val(prodprice);
              $(this).closest('tr').find(".line_packper").val(unitfactor);
              $(this).closest('tr').find(".line_litre").val(volumn);
              $(this).closest('tr').find(".line_percent").val(volumn_content);
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
