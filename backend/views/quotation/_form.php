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

$has_so = \backend\models\Sale::find()->where(['quotation_id' => $model->id])->one();

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
                            <?= $form->field($model, 'quotation_no')->textInput(['maxlength' => true, 'value' => $model->isNewRecord ? $runno : $model->quotation_no]) ?>
                        </div>
                        <div class="col-lg-3">
                            <?php $model->require_date = $model->isNewRecord ? date('d/m/Y') : date('d/m/Y', $model->require_date); ?>
                            <?= $form->field($model, 'require_date')->widget(DatePicker::className(), [
                                'options' => [
                                    'style' => 'font-weight: bold',
                                    'class' => 'quotation_date',
                                ],
                                'pluginOptions' => [
                                    'format' => 'dd/mm/yyyy',
                                    'todayHighlight' => true,
                                    'todayBtn' => true,
                                ]
                            ]) ?>
                        </div>
                        <div class="col-lg-3">
                            <?= $form->field($model, 'customer_id')->widget(Select2::className(), [
                                'data' => ArrayHelper::map(\backend\models\Customer::find()->all(), 'id', 'name'),
                                'options' => [
                                    'placeholder' => 'เลือกลูกค้า',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
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
                            <?= $form->field($model, 'currency')->widget(Select2::className(), [
                                'data' => ArrayHelper::map(\backend\helpers\Currency::asArrayObject(), 'id', 'name'),
                                'options' => [
                                    'placeholder' => 'เลือกสกุลเงิน',
                                    'onchange' => 'checkRate($(this))',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ]
                            ]) ?>
                            <div class="text-danger alert-currency" style="display: none"></div>
                        </div>
                        <div class="col-lg-3">
<!--                            <label for="">อัตราแลกเปลี่ยน</label>-->
<!--                            <input type="text" class="form-control rate" name="rate" readonly value="">-->
                            <?= $form->field($model, 'currency_rate')->textInput(['class'=>'form-control rate','readonly'=>'readonly']) ?>
                        </div>
                        <div class="col-lg-3">
                            <?php $xstatus = $model->isNewRecord ? 'open' : \backend\helpers\QuotationStatus::getTypeById($model->status); ?>
                            <?= $form->field($model, 'status')->textInput(['value' => $xstatus, 'readonly' => 'readonly']) ?>
                        </div>
                    </div>

                </div>
                <div class="col-lg-3">

                    <?= $form->field($model, 'note')->textarea(['maxlength' => true]) ?>


                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
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
                                <th style="width: 10%">ต้นทุน</th>
                                <th>ราคาขาย/ลัง</th>
                                <th>ราคารวม</th>
                                <th>-</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($model->isNewRecord): ?>
                                <tr>
                                    <td style="vertical-align: middle;text-align: center">

                                    </td>
                                    <td style="vertical-align: middle">
                                        <i class="fa fa-image"></i>
                                    </td>
                                    <td>
                                        <input type="hidden" class="productid" name="productid[]">
                                        <input type="hidden" class="stock_qty" value="0">
                                        <input type="hidden" class="stock-id" name="stock_id[]" value="">
                                        <input type="text" autocomplete="off" class="form-control productcode"
                                               name="prodcode[]" value="" onchange="itemchange($(this));"
                                               ondblclick="showfind($(this))">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control productname" name="prodname[]" value=""
                                               readonly>
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
                                        <input type="number" min="0" class="form-control line_qty" name="qty[]" value=""
                                               onchange="cal_num($(this))">
                                    </td>
                                    <td>
                                        <!--                                    <input style="text-align: right" type="text" class="form-control line_cost" name="cost[]" value="" readonly>-->
                                        <input style="text-align: right" type="text" class="form-control line_origin"
                                               name="origin[]" value="" readonly>
                                    </td>
                                    <td>
                                        <input style="text-align: right" type="text" class="form-control line_cost"
                                               name="cost[]" value="">
                                    </td>
                                    <td>
                                        <input type="hidden" name="line_price_origin" class="line-price-origin" value="">
                                        <input style="text-align: right" type="text" class="form-control line_price"
                                               name="price[]" value="" onchange="cal_num($(this));">
                                    </td>
                                    <td>
                                        <input style="text-align: right" type="text" class="form-control line_total"
                                               name="linetotal[]" value="" readonly>
                                    </td>
                                    <td>
                                        <div class="btn btn-sm btn-danger btn-removeline"
                                             onclick="return removeline($(this));"><i class="fa fa-trash-o"></i></div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php if (count($modelline) > 0): ?>
                                    <?php $i = 0; ?>
                                    <?php foreach ($modelline as $value): ?>
                                        <?php $i += 1; ?>
                                        <tr data-var="<?= $value->id ?>">
                                            <td style="vertical-align: middle;text-align: center">
                                                <?= $i ?>
                                            </td>
                                            <td style="vertical-align: middle;text-align: left">
                                                <?php
                                                if (\backend\models\Product::findImg($value->product_id) == ''):?>
                                                    <i class="fa fa-image"></i>
                                                <?php else: ?>
                                                    <?= Html::img('../web/uploads/images/' . \backend\models\Product::findImg($value->product_id), ['style' => 'width: 100%;left: 0px;top: 0px', 'class' => 'popover1']) ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" class="productid" name="productid[]"
                                                       value="<?= $value->product_id ?>">
                                                <input type="hidden" class="stock_qty" value="0">
                                                <input type="hidden" class="stock-id" name="stock_id[]"
                                                       value="<?= $value->stock_id ?>">
                                                <input type="text" autocomplete="off" class="form-control productcode"
                                                       name="prodcode[]"
                                                       value="<?= \backend\models\Product::findCode($value->product_id) ?>"
                                                       onchange="itemchange($(this));" ondblclick="showfind($(this))">

                                            </td>
                                            <td>
                                                <input type="text" class="form-control productname" name="prodname[]"
                                                       value="<?= \backend\models\Product::findName($value->product_id) ?>"
                                                       readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control line_packper"
                                                       value="<?= \backend\models\Product::findProductInfo($value->product_id)->unit_factor ?>"
                                                       readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control line_litre"
                                                       value="<?= \backend\models\Product::findProductInfo($value->product_id)->volumn ?>"
                                                       readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control line_percent"
                                                       value="<?= \backend\models\Product::findProductInfo($value->product_id)->volumn_content ?>"
                                                       readonly>
                                            </td>
                                            <td>
                                                <input type="number" min="0" style="text-align: right"
                                                       class="form-control line_qty" name="qty[]"
                                                       value="<?= $value->qty ?>" onchange="cal_num($(this));">
                                            </td>
                                            <td>
                                                <!--                                            <input type="text" class="form-control line_cost" name="cost[]" value="" readonly>-->
                                                <input type="text" class="form-control line_origin" name="origin[]"
                                                       value="<?= \backend\models\Product::findProductinfo($value->product_id) != null ? \backend\models\Product::findProductinfo($value->product_id)->origin : '' ?>"
                                                       readonly>
                                            </td>
                                            <td>
                                                <input style="text-align: right" type="text"
                                                       class="form-control line_cost"
                                                       name="cost[]"
                                                       value="<?= \backend\models\Product::findProductinfo($value->product_id) != null ? \backend\models\Product::findProductinfo($value->product_id)->cost : 0 ?>">
                                            </td>
                                            <td>
                                                <input type="hidden" name="line_price_origin" class="line-price-origin" value="">
                                                <input style="text-align: right" type="text"
                                                       class="form-control line_price" name="price[]"
                                                       value="<?= $value->price ?>" onchange="cal_num($(this));">
                                            </td>
                                            <td>
                                                <input style="text-align: right" type="text"
                                                       class="form-control line_total" name="linetotal[]"
                                                       value="<?= $value->price * $value->qty ?>" readonly>
                                            </td>
                                            <td>
                                                <div class="btn btn-sm btn-danger btn-removeline"
                                                     onclick="return removeline($(this));"><i class="fa fa-trash-o"></i>
                                                </div>
                                            </td>
                                        </tr>

                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align: center">

                                        </td>
                                        <td style="vertical-align: middle">
                                            <i class="fa fa-image"></i>
                                        </td>
                                        <td>
                                            <input type="hidden" class="productid" name="productid[]">
                                            <input type="hidden" class="stock_qty" value="0">
                                            <input type="hidden" class="stock-id" name="stock_id[]" value="">
                                            <input type="text" autocomplete="off" class="form-control productcode"
                                                   name="prodcode[]" value="" onchange="itemchange($(this));"
                                                   ondblclick="showfind($(this))">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control productname" name="prodname[]"
                                                   value="" readonly>
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
                                            <input type="number" min="0" style="text-align: right"
                                                   class="form-control line_qty" name="qty[]"
                                                   value="" onchange="cal_num($(this));">
                                        </td>
                                        <td>
                                            <!--                                        <input style="text-align: right" type="text" class="form-control line_cost" name="cost[]" value="" readonly>-->
                                            <input style="text-align: right" type="text"
                                                   class="form-control line_origin" name="origin[]" value="" readonly>
                                        </td>
                                        <td>
                                            <input style="text-align: right" type="text" class="form-control line_price"
                                                   name="price[]" value="" onchange="cal_num($(this));">
                                        </td>
                                        <td>
                                            <input style="text-align: right" type="text" class="form-control line_total"
                                                   name="linetotal[]" value="" readonly>
                                        </td>
                                        <td>
                                            <div class="btn btn-sm btn-danger btn-removeline"
                                                 onclick="return removeline($(this));"><i class="fa fa-trash-o"></i>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="6"></td>
                                <td style="text-align: right;font-weight: bold">ยอดรวม</td>
                                <td style="text-align: right;font-weight: bold" class="qty-sum">0.00</td>
                                <td colspan="3"></td>
                                <td style="text-align: right;font-weight: bold" class="total-sum">0.00</td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="btn btn-default btn-addline"><i class="fa fa-plus-circle"></i> เพิ่มรายการ</div>
                </div>
            </div>


            <hr/>

            <div class="pull-left">
                <?php if ($has_so && !$model->isNewRecord): ?>
                    <div style="border: 1px solid orange;width: 300px;text-align: center;border-radius: 25px;padding: 5px 0px 5px 0px;">
                        <?php echo "เลขที่ใบสั่งซื้อ " . $has_so->sale_no; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group pull-right">
                <?= Html::submitButton("<i class='fa fa-save'></i> บันทึก", ['class' => 'btn btn-success']) ?>
                <?php if (!$model->isNewRecord): ?>
                    <?= Html::Button("<i class='fa fa-print'></i> พิมพ์", ['class' => 'btn btn-warning btn-quote-print']) ?>
                    <?php if (!$has_so): ?>
                        <?= Html::Button("<i class='fa fa-random'></i> เปิดออเดอร์", ['class' => 'btn btn-primary btn-firm-sale']) ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <?php ActiveForm::end(); ?>
            <form id="form-quote" target="_blank" method="post"
                  action="<?= Url::to(['quotation/bill', 'id' => $model->id], true) ?>"></form>
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
                                <input type="text" class="form-control search-item" placeholder="ค้นหาสินค้า">
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
            <div class="modal-body" style="white-space:nowrap;overflow-y: auto">
                <input type="hidden" name="line_qc_product" class="line_qc_product" value="">
                <table class="table table-bordered table-striped table-list">
                    <thead>
                    <tr>
                        <th style="text-align: center">เลือก</th>
                        <th>รหัสสินค้า</th>
                        <th>รายละเอียด</th>
                        <th>คงเหลือ</th>
                        <th>Origin</th>
                        <th>ปริมาณ/ลัง</th>
                        <th>ลิตร/ขวด</th>
                        <th>%</th>
                        <th>คลัง</th>
                        <th>inv</th>
                        <th>inv.date</th>
                        <th>ใบอนุญาต</th>
                        <th>วันที่</th>
                        <th>ใบขน</th>
                        <th>วันที่</th>
                        <th>ลำดับ</th>
                        <th>สรรพสามิตร</th>
                        <th>กนอ.</th>
                        <th>วันที่</th>
                        <th>เข้า</th>
                        <th>ออก</th>


                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i
                            class="fa fa-close text-danger"></i> ปิดหน้าต่าง
                </button>
            </div>
        </div>

    </div>
</div>

<!--<div id="hover-div" display="none">-->
<!--    <img class="popover1" style="height: 100px;" src="http://transolid.com/assets/images/colors/previews/prev_sorrento_coast.jpg" title="some title text"/>-->
<!--</div>-->
<?php
$url_to_find = Url::to(['quotation/finditem'], true);
$url_to_firm = Url::to(['quotation/firmorder'], true);
$url_to_find_product = Url::to(['product/searchitem'], true);
$url_to_checkrate = Url::to(['quotation/check-rate'], true);
$url_to_get_photo = Url::to(['product/getphoto'],true);
$js = <<<JS
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
      //alert(textsearch);
      $.ajax({
              'type':'post',
              'dataType': 'json',
              'url': "$url_to_find",
              'data': {'txt': textsearch},
              'success': function(data) {
                // alert(data.length);return;
                 if(data.length == 0){
                      $(".table-list").hide();
                     $(".modal-error").show();
                 }else{
                     $(".modal-error").hide();
                     $(".table-list").show();
                     var html = "";
                     for(var i =0;i<=data.length -1;i++){
                           var all_qty = data[i]['all_qty'] == null?0:data[i]['all_qty'];
                            var in_q = data[i]['in_qty'] == null?0:data[i]['in_qty'];
                         var out_q = data[i]['out_qty'] == null?0:data[i]['out_qty'];
                         html +="<tr ondblclick='getitem($(this));'>" +
                          "<td style='vertical-align: middle;text-align: center'><div class='btn btn-info btn-sm' onclick='getitem($(this));'>เลือก</div></td>"+
                          "<td style='vertical-align: middle'>"+
                         data[i]['product_code']+"</td><td style='vertical-align: middle'>"+
                         data[i]['name']+"<input type='hidden' class='recid' value='"+data[i]['id']+"'/>" +
                          "<input type='hidden' class='prodcost' value='"+data[i]['cost']+"'/>" +
                          "<input type='hidden' class='prodprice' value='"+data[i]['usd_rate']+"'/>" +
                          "<input type='hidden' class='prodnet' value='"+data[i]['netweight']+"'/>" +
                          "<input type='hidden' class='prodgross' value='"+data[i]['grossweight']+"'/>" +
                          "<input type='hidden' class='prodorigin' value='"+data[i]['origin']+"'/>" +
                          "<input type='hidden' class='prodgeo' value='"+data[i]['geolocation']+"'/>" +
                          "<input type='hidden' class='unitfactor' value='"+data[i]['unit_factor']+"'/>" +
                          "<input type='hidden' class='volumn' value='"+data[i]['volumn']+"'/>" +
                          "<input type='hidden' class='volumn_content' value='"+data[i]['volumn_content']+"'/>" +
                           "<input type='hidden' class='stock_refid' value='"+data[i]['stock_id']+"'/>" +
                           "<input type='hidden' class='stock_price' value='"+data[i]['thb_amount']+"'/>" +
                             "<input type='hidden' class='stock_qty' value='"+all_qty+"'/>" +
                           "</td>"+
                             "<td style='font-weight: bold;text-align: right;'>"+ parseFloat(in_q).toLocaleString()+"</td>" +
                           "<td>"+data[i]['origin']+"</td>"+
                          "<td>"+data[i]['unit_factor']+"</td>"+
                          "<td>"+data[i]['volumn']+"</td>"+
                          "<td>"+data[i]['volumn_content']+"</td>"+
                           "<td>"+data[i]['warehouse_name']+"</td>"+
                           "<td>"+data[i]['invoice_no']+"</td>"+
                           "<td>"+data[i]['invoice_date']+"</td>" +
                           "<td>"+data[i]['permit_no']+"</td>" +
                           "<td>"+data[i]['permit_date']+"</td>" +
                             "<td>"+data[i]['transport_in_no']+"</td>" +
                           "<td>"+data[i]['transport_in_date']+"</td>" +
                                     "<td>"+data[i]['sequence']+"</td>" +
                           "<td>"+data[i]['excise_no']+"</td>" +
                           "<td>"+data[i]['kno_no_in']+"</td>" +
                           "<td>"+data[i]['kno_in_date']+"</td>" +
                            "<td style='color:green;text-align: right;'>"+parseFloat(in_q).toLocaleString()+"</td>" +
                           "<td style='color:red;text-align: right;'>"+parseFloat(out_q).toLocaleString()+"</td>" +
                         
                           "</tr>"
                          
                     }
                     $(".table-list tbody").html(html);
                     
                 }
              },
              error: function(err){
                  //alert(err);
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
    
     $.ajax({
              'type':'post',
              'dataType': 'json',
              'url': "$url_to_find",
              'data': {'txt': "*"},
              'success': function(data) {
                // alert(data[0]['warehouse_name']);return;
                 if(data.length == 0){
                      $(".table-list").hide();
                     $(".modal-error").show();
                 }else{
                     $(".modal-error").hide();
                     $(".table-list").show();
                    
                     var html = "";
                     for(var i =0;i<=data.length -1;i++){
                         var all_qty = data[i]['all_qty'] == null?0:data[i]['all_qty'];
                         var in_q = data[i]['in_qty'] == null?0:data[i]['in_qty'];
                         var out_q = data[i]['out_qty'] == null?0:data[i]['out_qty'];
                         
                          var inv_date = '';
                          var permit_date = '';
                          var transport_date = '';
                          var kno_date = '';
                          
                          if(data[i]['invoice_date']!='' && data[i]['invoice_date'] != null){
                              //alert(data[i]['invoice_date'].length);
                              inv_date = data[i]['invoice_date'].substr(6,4)==1970?'': data[i]['invoice_date'];
                          }
                        if(data[i]['permit_date']!='' && data[i]['permit_date'] != null){
                             permit_date = data[i]['permit_date'].substr(6,4)==1970?'': data[i]['permit_date'];
                        }
                         if( data[i]['transport_in_date']!='' && data[i]['transport_in_date'] != null){
                              transport_date = data[i]['transport_in_date'].substr(6,4)==1970?'': data[i]['transport_in_date'];
                         }
                         if(data[i]['kno_in_date']!='' && data[i]['kno_in_date'] != null){
                              kno_date = data[i]['kno_in_date'].substr(6,4)==1970?'': data[i]['kno_in_date'];
                         }
                         
                         html +="<tr ondblclick='getitem($(this));'>" +
                         "<td style='vertical-align: middle;text-align: center'><div class='btn btn-info btn-sm' onclick='getitem($(this));'>เลือก</div></td>"+
                          "<td style='vertical-align: middle'>"+
                         data[i]['product_code']+"</td><td style='vertical-align: middle'>"+
                         data[i]['name']+"<input type='hidden' class='recid' value='"+data[i]['id']+"'/>" +
                          "<input type='hidden' class='prodcost' value='"+data[i]['cost']+"'/>" +
                          "<input type='hidden' class='prodprice' value='"+data[i]['usd_rate']+"'/>" +
                          "<input type='hidden' class='prodnet' value='"+data[i]['netweight']+"'/>" +
                          "<input type='hidden' class='prodgross' value='"+data[i]['grossweight']+"'/>" +
                          "<input type='hidden' class='prodorigin' value='"+data[i]['origin']+"'/>" +
                          "<input type='hidden' class='prodgeo' value='"+data[i]['geolocation']+"'/>" +
                          "<input type='hidden' class='unitfactor' value='"+data[i]['unit_factor']+"'/>" +
                          "<input type='hidden' class='volumn' value='"+data[i]['volumn']+"'/>" +
                          "<input type='hidden' class='volumn_content' value='"+data[i]['volumn_content']+"'/>" +
                          "<input type='hidden' class='stock_refid' value='"+data[i]['stock_id']+"'/>" +
                          "<input type='hidden' class='stock_price' value='"+data[i]['thb_amount']+"'/>" +
                          "<input type='hidden' class='stock_qty' value='"+all_qty+"'/>" +
                           "</td>"+
                           "<td>"+data[i]['origin']+"</td>"+
                        "<td>"+data[i]['unit_factor']+"</td>"+
                          "<td>"+data[i]['volumn']+"</td>"+
                          "<td>"+data[i]['volumn_content']+"</td>"+
                             "<td>"+data[i]['warehouse_name']+"</td>"+
                           "<td>"+data[i]['invoice_no']+"</td>"+
                           "<td>"+inv_date+"</td>"+
                          "<td>"+data[i]['permit_no']+"</td>"+
                          "<td>"+permit_date+"</td>"+
                            "<td>"+data[i]['transport_in_no']+"</td>" +
                           "<td>"+transport_date+"</td>" +
                           "<td>"+data[i]['sequence']+"</td>" +
                           "<td>"+data[i]['excise_no']+"</td>" +
                           "<td>"+data[i]['kno_no_in']+"</td>" +
                           "<td>"+kno_date+"</td>" +
                           "<td style='color:green;text-align: right;'>"+parseFloat(in_q).toLocaleString()+"</td>" +
                           "<td style='color:red;text-align: right;'>"+parseFloat(out_q).toLocaleString()+"</td>" +
                           "<td style='font-weight: bold;text-align: right;'>"+ parseFloat(in_q).toLocaleString()+"</td>" +
                           "</tr>"
                           
                     }
                     $(".table-list tbody").html(html);
                     
                 }
              }
            });
      $("#findModal").modal("show");
 }
 function cal_num(e){
     var qty = e.closest("tr").find(".line_qty").val();
     var stock_qty = e.closest("tr").find(".stock_qty").val();
     var price = e.closest("tr").find(".line_price").val();
     // alert(stock_qty);
     if(qty == ""){qty = 0;}
     if(price == ""){price = 0;}
     if(stock_qty == ""){stock_qty = 0;}
     
     if(qty > stock_qty){
         alert("จำนวนที่ต้องการมากกว่าจำนวนคงเหลือ");
         e.closest("tr").find(".line_qty").val(stock_qty);
         return false;
     }
     
     var total = parseFloat(qty).toFixed(2) * parseFloat(price).toFixed(2);
     e.closest("tr").find(".line_total").val("");
     e.closest("tr").find(".line_total").val(parseFloat(total).toFixed(2));
     
     cal_all();
   }
 
 function getitem(e){
    var prodcode = e.closest("tr").find("td:eq(1)").text();
    var prodname = e.closest("tr").find("td:eq(2)").text();
    var prodorigin = e.closest("tr").find("td:eq(3)").text()=="null"?'':e.closest("tr").find("td:eq(3)").text();
    var prodid = e.closest("tr").find(".recid").val();
    var prodcost = e.closest("tr").find(".prodcost").val();
    var prodprice = e.closest("tr").find(".prodprice").val();
    var unitfactor = e.closest("tr").find(".unitfactor").val();
    var stock_id = e.closest("tr").find(".stock_refid").val();
    var stock_price = e.closest("tr").find(".stock_price").val();
    var volumn = e.closest("tr").find(".volumn").val();
    var volumn_content = e.closest("tr").find(".volumn_content").val();
    var stock_qty = e.closest("tr").find(".stock_qty").val();
    
    var c_rate = $(".rate").val();
    var line_price = parseFloat(c_rate) * parseFloat(prodprice);
    
    if(c_rate == ''){
        alert("กรุณาตรวจสอบ Exchange Rate");
        return;
    }
    
   // alert(stock_qty);
    $(".table-quotation tbody tr").each(function() {
        // if($(this).closest('tr').find(".productcode").val() == prodcode){
        //   alert("รายการสินค้านี้ซ้ำ");return false;   
        // }
        if($(this).index() == currow){
              let html_photo = '';
              $.ajax({
              'type':'post',
              'dataType': 'html',
              'async': false,
              'url': "$url_to_get_photo",
              'data': {'product_id': prodid},
              'success': function(data) {
                  //  alert(data);
                    html_photo = data;
                 }
              });
            
               $(this).closest('tr').find("td:eq(1)").html(html_photo);
              $(this).closest('tr').find(".productcode").val(prodcode);
              $(this).closest('tr').find(".stock_qty").val(stock_qty);
              $(this).closest('tr').find(".productname").val(prodname);
              $(this).closest('tr').find(".productid").val(prodid);
              $(this).closest('tr').find(".line_qty").val(1);
              $(this).closest('tr').find(".stock-id").val(stock_id);
              $(this).closest('tr').find(".line_cost").val(prodprice);
              $(this).closest('tr').find(".line_origin").val(prodorigin);
              $(this).closest('tr').find(".line_price").val(prodprice);
              $(this).closest('tr').find(".line_packper").val(unitfactor);
              $(this).closest('tr').find(".line_litre").val(volumn);
              $(this).closest('tr').find(".line_percent").val(volumn_content);
              
                $(this).closest('tr').find(".line-price-origin").val(prodprice);
        }
        cal_num($(this));
    });
    $("#findModal").modal("hide");
 }
 function cal_all(){
      var totalall = 0;
      var totalqty = 0;
      $(".table-quotation tbody tr").each(function() {
          var linetotal = $(this).closest("tr").find(".line_total").val();
          var lineqty = $(this).closest("tr").find(".line_qty").val();
          
          if(linetotal == ''){linetotal = 0;}
          if(lineqty == ''){lineqty = 0;}
          
          totalall = parseFloat(totalall) + parseFloat(linetotal);
          totalqty = parseFloat(totalqty) + parseFloat(lineqty);
      });
      $(".qty-sum").text(parseFloat(totalqty).toFixed(2));
      $(".total-sum").text(parseFloat(totalall).toFixed(2));
 }
 
 function checkRate(e){
     var c_m = 0;
      var q_date = new Date();
                  var q_date_arr = $(".quotation_date").val().split('/');
                  if(q_date_arr.length >0){
                      q_date = q_date_arr[2] +'/'+q_date_arr[1]+'/'+q_date_arr[0];
                      c_m = q_date_arr[1];
                  }
                  
     let id = e.val();
     if(id){
         //alert(c_m);
         $.ajax({
              'type':'post',
              'dataType': 'json',
              'url': "$url_to_checkrate",
              'data': {'cur_id': id,'month': c_m},
              'success': function(data) {
                 //alert(data);
                  // alert(new Date(data[0]['exp_date']));
                  // alert(data[0]['exp_date']);
                 //  alert(q_date);
                 var exp_date = data[0]['exp_date'];
                 var rate_name = data[0]['currency'];
                 if(exp_date < q_date && rate_name !='THB'){
                       $(".alert-currency").html("วันที่อัตราแลกเปลี่ยนหมดอายุแล้ว หรือ ยังไม่ได้ป้อนค่าอัตราแลกเปลี่ยน").show();
                      $(".rate").val('');
                      return false;
                 }
                 
                  if(data.length > 0){
                      $(".rate").val(data[0]['exc_rate']);
                        $(".alert-currency").hide();
                  }else{
                      $(".alert-currency").html("ไม่พบข้อมูลอัตราแลกเปลี่ยน").show();
                      $(".rate").val('');
                      return false;
                  } 
                  re_cal();
              }
              
         });
         
     }
 }
  function re_cal() {
   $(".table-quotation tbody tr").each(function() {
        var line_price =  $(this).closest('tr').find(".line-price-origin").val();
        var line_qty =  $(this).closest('tr').find(".line_qty").val();
        alert(line_price);
        var cur_rate = $(".rate").val();
        var new_price = parseFloat(line_price) * parseFloat(cur_rate);
        var new_line_total = parseFloat(new_price) * parseFloat(line_qty);
        $(this).closest('tr').find(".line_price").val(new_price);
        $(this).closest('tr').find(".line_total").val(new_line_total);
        cal_all();
    });
 }
 
JS;
$this->registerJs($js, static::POS_END);
?>
