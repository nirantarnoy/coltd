<?php
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-lg-12">
        <h1>Invoice No: <?=$modelinv->invoice_no;?></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-body">
            <div class="table-responsive" style="overflow-x: scroll;">
                <form id="form-recieve" action="<?=Url::to(['inboundinv/recieve'],true)?>" method="post">
                    <input type="hidden" name="invoice_no" value="<?=$modelinv->invoice_no;?>">
                    <input type="hidden" name="invoice_id" value="<?=$modelinv->id;?>">
                    <input type="hidden" name="invoice_date" value="<?=$modelinv->invoice_date;?>">
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
                        <th>วันที่ใบขน</th>
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
                        <?php $i=0;?>
                        <?php foreach ($model as $value):?>
                        <?php
                            $product_data = \backend\models\Product::findProductinfo($value->product_id);
                            $price_total = $value->line_qty * $value->line_price;
                            $usd = \backend\models\Productstock::findUSDPriceCarton($value->product_id);
                            $thb = \backend\models\Productstock::findTHBPriceCarton($value->product_id);
                            $bottle_qty = $product_data->unit_factor * $value->line_qty;
                            $geo = \backend\models\Product::findGeo($value->product_id);
                            ?>
                        <?php $i+=1;?>
                            <tr>
                                <td style="text-align: center;vertical-align: middle"><?=$i;?></td>
                                <td>
                                    <input type="hidden" class="productcode" name="product_id[]" value="<?=$value->product_id?>">
                                    <input type="hidden" class="recid" name="recid[]" value="<?=$value->id?>">
                                    <input type="text" style="width: 400px" class="form-control productname" name="" value="<?=\backend\models\Product::findName($value->product_id)?>" onchange="itemchange($(this));" ondblclick="showfind($(this))">
                                </td>
                                <td><input type="text" style="width: 100px" class="form-control product-pack1" name="product_pack1[]"  value="<?=number_format($usd)?>"></td>
                                <td><input type="text" style="width: 100px" class="form-control product-pack2" name="product_pack2[]" value="<?=number_format($thb * $usd)?>"></td>
                                <td><input style="width: 70px" style="width: 100px" type="number" class="form-control line_qty" name="line_qty[]" onchange="line_cal($(this))" value="<?=$value->line_qty?>"></td>
                                <td><input type="number" style="width: 100px" class="form-control line_packing" name="line_packing[]" readonly value="<?=$product_data->unit_factor?>"></td>
                                <td><input type="text" style="width: 100px;text-align: right" class="form-control line_price_per" name="line_price_per[]" value="<?=$value->line_price?>"></td>
                                <td><input style="width: 100px;text-align: right" type="text" class="form-control line_total_amount" name="line_total_amount[]" value="<?=number_format($price_total,2)?>" readonly></td>
                                <td><input type="text" style="width: 100px;text-align: right;" class="form-control line_bottle_qty" readonly name="line_bottle_qty[]" value="<?=number_format($bottle_qty)?>"></td>
                                <td><input type="text" style="width: 100px" class="form-control line_litre" name="line_litre[]" value="<?=$product_data->volumn?>"></td>
                                <td><input type="text" style="width: 100px" class="form-control line_net" name="line_net[]" value="<?=$product_data->netweight?>" readonly></td>
                                <td><input type="text" style="width: 100px" class="form-control line_gross" name="line_gross[]" value="<?=$product_data->grossweight?>" readonly></td>
                                <td><input type="text" style="width: 200px" class="form-control line_transport_in_no" name="line_transport_in_no[]" value="" required></td>
                                <td><input type="date" id="cut_date_<?=$i?>" style="width: 200px" class="form-control line_transport_in_date" name="line_transport_in_date[]" required value="<?=$value->transport_in_date =='' || $value->transport_in_date == Null? date('d-m-Y'):date('d-m-Y',strtotime($value->transport_in_date))?>"></td>
                                <td><input type="text" style="width: 100px" class="form-control line_num" name="line_num[]" value="<?=$value->line_num?>"></td>
                                <td><input style="width: 100px" type="text" class="form-control line_geo" name="line_geo[]" value="<?=$geo?>" readonly></td>
                                <td><input type="text" style="width: 100px" class="form-control line_origin" name="line_origin[]" value="<?=$product_data->origin?>" readonly></td>
                                <td><input type="text" style="width: 300px" class="form-control line_excise_no" name="line_excise_no[]" value="<?=$product_data->excise_no?>" readonly></td>
                                <td><input type="text" style="width: 100px" class="form-control line_excise_date" name="line_excise_date[]" value="<?=$product_data->excise_date?>" readonly></td>
                                <td><input type="text" style="width: 100px" class="form-control line_kno_no" name="line_kno_no[]" readonly value="<?=$value->kno_no_in?>"></td>
                                <td><input type="text" style="width: 100px" class="form-control line_kno_date" name="line_kno_date[]" value="<?=date('d/m/Y',strtotime($value->kno_in_date))?>" readonly></td>
                                <td><input type="text" style="width: 100px" class="form-control line_permit_no" name="line_permit_no[]" value=""></td>
                                <td><input type="date" id="permit_date_<?=$i?>" style="width: 200px" class="form-control line_permit_date" name="line_permit_date[]" value="<?=$value->permit_date =='' || $value->permit_date == Null? date('d-m-Y'):date('d-m-Y',strtotime($value->permit_date))?>"></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                </form>
            </div>
            <br>
            <?php //if(!$modelinv->posted):?>
            <div class="btn btn-warning btn-success btn-approve" onclick="approve($(this))"> ยืนยันยอดรับเข้า</div>
            <?php //endif;?>
        </div>
    </div>
</div>
<?php
$this->registerJsFile( '@web/js/sweetalert.min.js',['depends' => [\yii\web\JqueryAsset::className()]],static::POS_END);
$this->registerCssFile( '@web/css/sweetalert.css');

$js=<<<JS
$(function() {
 
});
function line_cal(e){
   // alert();
    let line_qty = e.val();
    let line_price = e.closest("tr").find(".line_price_per").val();
    let line_perpack = e.closest("tr").find(".line_packing").val();
    
    e.closest("tr").find(".line_total_amount").val(parseFloat(line_price * line_qty).toFixed(2));
    e.closest("tr").find(".line_bottle_qty").val(parseFloat(line_perpack * line_qty).toFixed(0));
}
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
              $("#form-recieve").submit();     
        });
    }
JS;
$this->registerJs($js,static::POS_END);
?>
