<?php
?>
<div class="row">
    <div class="col-lg-12">
        <h1>Invoice No: <?=$invoice_no;?></h1>
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

                        <?php foreach ($model as $value):?>
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
                    </tbody>
                </table>
            </div>
            <br>
            <div class="btn btn-warning btn-success btn-approve" onclick="approve($(this))"> ยืนยันยอดรับเข้า</div>
        </div>
    </div>
</div>
<?php
$this->registerJsFile( '@web/js/sweetalert.min.js',['depends' => [\yii\web\JqueryAsset::className()]],static::POS_END);
$this->registerCssFile( '@web/css/sweetalert.css');

$js=<<<JS
$(function() {
  $('.btn-approve').click(function() {
    
  });
});

function approve(e){
        //e.preventDefault();
        var url = e.attr("data-url");
        swal({
              title: "ตัองการบันทึกยอดรับเข้าใช่หรือไม่?",
              text: "",
              type: "warning",
              showCancelButton: true,
              closeOnConfirm: false,
              showLoaderOnConfirm: true
            }, function () {
              e.attr("href",url); 
              e.trigger("click");        
        });
    }
JS;
$this->registerJs($js,static::POS_END);
?>