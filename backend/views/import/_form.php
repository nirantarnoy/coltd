<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use toxor88\switchery\Switchery;
use yii\helpers\Url;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

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

    <?php $form = ActiveForm::begin(['options'=>['enctype' => 'multipart/form-data']]); ?>

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
                <?= $form->field($model, 'vendor_id')->widget(Select2::className(),[
                        'data'=>ArrayHelper::map(\backend\models\Vendor::find()->all(),'id','name'),
                        'options' => ['placeholder'=>'เลือกคู่ค้า'],
                        'pluginOptions' => [
                                'allowClear'=> true,
                        ]
                ])->label() ?>
            </div>
        </div>
       <div class="row">
           <div class="col-lg-6">
               <?php echo $form->field($model, 'status')->widget(Switchery::className(),['options'=>['label'=>'','class'=>'form-control']])->label() ?>
           </div>
       </div>

        <div class="row">
            <div class="col-lg-6">
                <?php echo '<label class="control-label">แนบไฟล์</label>';
                echo FileInput::widget([
                    'model' => $modelfile,
                    'attribute' => 'file',
                    'options' => [
                        'multiple' => true ,
                        'accept' => '.pdf',
                    ]
                ]);
                ?>
            </div>
        </div>

        <?php //echo $form->field($model, 'vendor_id')->textInput() ?>

        <br>
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            <div class="btn btn-default btn-import-file"><i class="fa fa-upload text-primary"></i> นำเข้าใบนำเข้าจาก Excel</div>
            <?php if(!$model->isNewRecord):?>
              <a class="btn btn-default btn-export-file"  href="<?=Url::to(['import/export','id'=>$model->id],true)?>"><i class="fa fa-download text-primary"></i> นำออกเป็น Excel</a>
            <?php endif;?>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-body">
            <div class="table-responsive" style="overflow-x: scroll;">
            <table class="table table-importline" >
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
                <?php if($model->isNewRecord): ?>
                    <tr>
                        <td></td>
                        <td>
                            <input type="hidden" class="productid" name="product_id[]" value="">
                            <input type="text" style="width: 400px" class="form-control productname" name="product_name[]" value="" onchange="itemchange($(this));" ondblclick="showfind($(this))">
                        </td>
                        <td><input type="text" class="form-control product-pack1" name="product_pack1[]"  value=""></td>
                        <td><input type="text" class="form-control product-pack2" name="product_pack2[]" value=""></td>
                        <td><input style="width: 70px" type="number" class="form-control line_qty" name="line_qty[]" value=""></td>
                        <td><input type="number" class="form-control line_packing" name="line_packing[]" value=""></td>
                        <td><input type="text" class="form-control line_price_per" name="line_price_per[]" value=""></td>
                        <td><input style="width: 100px" type="text" class="form-control line_total_amount" name="line_total_amount[]" value="" readonly></td>
                        <td><input type="text" class="form-control line_bottle_qty" name="line_bottle_qty[]" value=""></td>
                        <td><input type="text" class="form-control line_litre" name="line_litre[]" value=""></td>
                        <td><input type="text" class="form-control line_net" name="line_net[]" value="" readonly></td>
                        <td><input type="text" class="form-control line_gross" name="line_gross[]" value="" readonly></td>
                        <td><input type="text" class="form-control line_transport_in_no" name="line_transport_in_no[]" value=""></td>
                        <td><input type="text" class="form-control line_num" name="line_num[]" value=""></td>
                        <td><input style="width: 75px" type="text" class="form-control line_geo" name="line_geo[]" value="" readonly></td>
                        <td><input type="text" class="form-control line_origin" name="line_origin[]" value="" readonly></td>
                        <td><input type="text" class="form-control line_excise_no" name="line_excise_no[]" value=""></td>
                        <td><input type="text" class="form-control line_excise_date" name="line_excise_date[]" value=""></td>
                        <td><input type="text" class="form-control line_kno_no" name="line_kno_no[]" value=""></td>
                        <td><input type="text" class="form-control line_kno_date" name="line_kno_date[]" value=""></td>
                        <td><input type="text" class="form-control line_permit_no" name="line_permit_no[]" value=""></td>
                        <td><input type="text" class="form-control line_permit_date" name="line_permit_date[]" value=""></td>
                    </tr>
                <?php else:?>
                   <?php foreach ($modelline as $value):?>
                        <tr>
                            <td></td>
                            <td>
                                <input type="hidden" class="productcode" name="product_id[]" value="<?=$value->product_id?>">
                                <input type="hidden" class="recid" name="recid[]" value="<?=$value->id?>">
                                <input type="text" style="width: 400px" class="form-control productname" name="" value="<?=\backend\models\Product::findName($value->product_id)?>" onchange="itemchange($(this));" ondblclick="showfind($(this))">
                            </td>
                            <td><input type="text" class="form-control product-pack1" name="product_pack1[]"  value="<?=$value->price_pack1?>"></td>
                            <td><input type="text" class="form-control product-pack2" name="product_pack2[]" value="<?=$value->price_pack2?>"></td>
                            <td><input style="width: 70px" type="number" class="form-control line_qty" name="line_qty[]" value="<?=$value->qty?>"></td>
                            <td><input type="number" class="form-control line_packing" name="line_packing[]" value="<?=$value->product_packing?>"></td>
                            <td><input type="text" class="form-control line_price_per" name="line_price_per[]" value="<?=$value->price_per?>"></td>
                            <td><input style="width: 100px" type="text" class="form-control line_total_amount" name="line_total_amount[]" value="<?=$value->total_price?>" readonly></td>
                            <td><input type="text" class="form-control line_bottle_qty" name="line_bottle_qty[]" value="<?=$value->total_qty?>"></td>
                            <td><input type="text" class="form-control line_litre" name="line_litre[]" value="<?=$value->weight_litre?>"></td>
                            <td><input type="text" class="form-control line_net" name="line_net[]" value="<?=$value->netweight?>" readonly></td>
                            <td><input type="text" class="form-control line_gross" name="line_gross[]" value="<?=$value->grossweight?>" readonly></td>
                            <td><input type="text" class="form-control line_transport_in_no" name="line_transport_in_no[]" value="<?=$value->transport_in_no?>"></td>
                            <td><input type="text" class="form-control line_num" name="line_num[]" value="<?=$value->line_num?>"></td>
                            <td><input style="width: 75px" type="text" class="form-control line_geo" name="line_geo[]" value="<?=$value->position?>" readonly></td>
                            <td><input type="text" class="form-control line_origin" name="line_origin[]" value="<?=$value->position?>" readonly></td>
                            <td><input type="text" class="form-control line_excise_no" name="line_excise_no[]" value="<?=$value->excise_no?>"></td>
                            <td><input type="text" class="form-control line_excise_date" name="line_excise_date[]" value="<?=$value->excise_date?>"></td>
                            <td><input type="text" class="form-control line_kno_no" name="line_kno_no[]" value="<?=$value->kno?>"></td>
                            <td><input type="text" class="form-control line_kno_date" name="line_kno_date[]" value="<?=$value->kno_date?>"></td>
                            <td><input type="text" class="form-control line_permit_no" name="line_permit_no[]" value="<?=$value->permit_no?>"></td>
                            <td><input type="text" class="form-control line_permit_date" name="line_permit_date[]" value="<?=$value->permit_date?>"></td>
                        </tr>
                    <?php endforeach;?>
                <?php endif;?>
                </tbody>
            </table>
            </div>
                <br>
                <div class="btn btn-default btn-add-line"><i class="fa fa-plus-circle"></i> เพิ่มรายการ</div>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

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
<?php
$url_to_find = Url::to(['quotation/finditem'],true);
$url_to_find_product = Url::to(['product/searchitem'],true);
$url_to_import_export = Url::to(['import/export'],true);
$js=<<<JS
$(function() {
    var importid = "$model->id";
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
                           "</td>"+
                           "<td>"+data[i]['origin']+"</td>"+
                           "<td style='vertical-align: middle;text-align: center'><div class='btn btn-info btn-sm' onclick='getitem($(this));'>เลือก</div></td></tr>"
                     }
                     $(".table-list tbody").html(html);
                     
                 }
              }
            });
  });
  $(".btn-add-line").click(function() {
    var tr = $(".table-importline tbody tr:last");
          //
          // if(tr.closest("tr").find(".productcode").val() == ""){
          //     tr.closest("tr").find(".productcode").css({'border-color': 'red'});
          //     tr.closest("tr").find(".productcode").focus();
          //     return;
          // }else{
          //     tr.closest("tr").find(".productcode").css({'border-color': ''});
          // }
          
          var linenum = 0;
          var clone = tr.clone();
          clone.find(":text").val("");
          clone.attr("data-var","");
          
          // clone.find(".line_qty,.line_price").on("keypress",function(event){
          //       $(this).val($(this).val().replace(/[^0-9\.]/g,""));
          //       if((event.which != 46 || $(this).val().indexOf(".") != -1) && (event.which <48 || event.which >57)){event.preventDefault();}
          // });
          
          tr.after(clone);
          
           $(".table-importline tbody tr").each(function(){
             linenum+=1;
             $(this).closest("tr").find("td:eq(0)").text(linenum);
           });
  })
})

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
                           "</td>"+
                           "<td>"+data[i]['origin']+"</td>"+
                           "<td style='vertical-align: middle;text-align: center'><div class='btn btn-info btn-sm' onclick='getitem($(this));'>เลือก</div></td></tr>"
                     }
                     $(".table-list tbody").html(html);
                     
                 }
              }
            });
 }
 
 function getitem(e){
    var prodcode = e.closest("tr").find("td:eq(0)").text();
    var prodname = e.closest("tr").find("td:eq(1)").text();
    var prodorigin = e.closest("tr").find("td:eq(2)").text()=="null"?'':e.closest("tr").find("td:eq(2)").text();
    var prodid = e.closest("tr").find(".recid").val();
    var prodcost = e.closest("tr").find(".prodcost").val();
    var prodprice = e.closest("tr").find(".prodprice").val() == "null"?'0':e.closest("tr").find(".prodprice").val();
    var prodnet = e.closest("tr").find(".prodnet").val() == "null"?'0':e.closest("tr").find(".prodnet").val();
    var prodgross = e.closest("tr").find(".prodgross").val() == "null"?'0':e.closest("tr").find(".prodgross").val();
    var prodorigin = e.closest("tr").find(".prodorigin").val() == "null"?'':e.closest("tr").find(".prodorigin").val();
    var prodgeo = e.closest("tr").find(".prodgeo").val() == "null"?'':e.closest("tr").find(".prodgeo").val();
    $(".table-importline tbody tr").each(function() {
        if($(this).closest('tr').find(".productcode").val() == prodcode){
          alert("รายการสินค้านี้ซ้ำ");return false;   
        }
        if($(this).index() == currow){
              $(this).closest('tr').find(".productcode").val(prodcode);
              $(this).closest('tr').find(".productname").val(prodcode);
              $(this).closest('tr').find(".productid").val(prodid);
              $(this).closest('tr').find(".line_qty").val(1);
              $(this).closest('tr').find(".line_cost").val(prodcost);
              $(this).closest('tr').find(".line_origin").val(prodorigin);
              $(this).closest('tr').find(".line_price").val(prodprice);
              $(this).closest('tr').find(".line_net").val(prodnet);
              $(this).closest('tr').find(".line_gross").val(prodgross);
              $(this).closest('tr').find(".line_origin").val(prodorigin);
              $(this).closest('tr').find(".line_geo").val(prodgeo);
              var melen = $(this).closest('tr').find(".productname").val().length * 10;
             
              //alert(melen);
              
              $(this).closest('tr').find(".productname").css({'width': 400});
             // $(this).parent()..width(melen);
              
        }
      //  cal_num($(this));
    });
    ;
    $("#findModal").modal("hide");
 }

JS;

$this->registerJs($js,static::POS_END);

?>
