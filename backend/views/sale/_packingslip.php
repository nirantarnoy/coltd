<?php
use yii\helpers\Url;
/**
 * Created by PhpStorm.
 * User: niran.w
 * Date: 25/02/2019
 * Time: 09:54:49
 */
$this->title = "Packing List";
?>
<h2>
    <?php echo $this->title;?>
</h2>
<div class="row">
    <div class="panel">
        <div class="panel-heading">
            <div style="border: 1px solid orange;width: 300px;text-align: center;border-radius: 25px;padding: 5px 0px 5px 0px;">
                <?php echo "เลขที่ใบสั่งซื้อ ".$model->sale_no;?>
            </div>

        </div>
        <div class="panel-body" style="overflow-y: auto;white-space:nowrap ">
            <form action="<?=Url::to(['sale/savepicking'],true)?>" method="post" id="form-packing">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="text-align: center">#</th>
                        <th style="text-align: center">รายการสินค้า</th>
                        <th>NW</th>
                        <th>GW</th>
                        <th>ราคาต่อลัง(บาท)</th>
                        <th >จำนวน</th>
                        <th >หน่วยนับ</th>
                        <th style="background-color: #1b6d85;color: white">ราคารวม</th>
                        <th style="text-align: center">เลขที่ใบนำเขา้</th>
                        <th style="text-align: center">วันที่</th>
                        <th style="text-align: center">รายการที่</th>
                        <th style="text-align: center">พิกัด</th>
                        <th style="text-align: center">ประเทศต้นกำเหนิด</th>
                        <th style="text-align: center">ใบขนขาออก</th>
                        <th style="text-align: center">วันที่</th>
                        <th style="text-align: center">invoice</th>
                        <th style="text-align: center">invoice/date</th>
                        <th style="text-align: center">จำนวนเงิน</th>
                        <th style="text-align: center">ใบอนุญาต</th>
                        <th style="text-align: center">วันที่</th>
                        <th style="text-align: center">กนอ</th>
                        <th style="text-align: center">วันที่</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($query)):?>
                    <?php //$i=0; ?>
                      <?php for($i=0;$i<=count($query)-1;$i++):?>
                            <?php //$i+=1; ?>
                        <tr>
                            <td style="vertical-align: middle">
                                <input type="hidden" name="stock_id[]" value="<?=$query[$i]['stock_id']?>">
                                <input type="hidden" name="sale_id[]" value="<?=$query[$i]['sale_id']?>">
                                <input type="hidden" name="line_price[]" value="<?=$query[$i]['price']?>">
                                <input type="hidden" name="sale_date" value="<?=date('d-m-Y',$query[$i]['require_date']);?>">
                                <input type="hidden" name="sale_line_id[]" value="<?=$query[$i]['sale_line_id']?>">
                                <?=$i+1?>
                            </td>
                            <td style="vertical-align: middle">
                                <?=\backend\models\Product::findEng($query[$i]['product_id'])?>
                                <input type="hidden" name="product_id[]" class="productid" value="<?=$query[$i]['product_id']?>" >
                            </td>
                            <td style="vertical-align: middle">
                                <?=number_format(\backend\models\Product::findProductInfo($query[$i]['product_id'])->netweight, 2)?>
                            </td>
                            <td style="vertical-align: middle">
                                <?=number_format(\backend\models\Product::findProductInfo($query[$i]['product_id'])->grossweight,2)?>
                            </td>
                            <td style="vertical-align: middle;text-align: right">
                                <input type="text" class="form-control" name="line_per_carton[]" value="<?=number_format((float)$query[$i]['price'],2);?>">
                            </td>
                            <td style="vertical-align: middle">
                                <input type="text" class="form-control line_qty" name="line_qty[]" style="width: 80px;" value="<?=$query[$i]['qty']?>">
                            </td>
                            <td style="vertical-align: middle">
                                <?=\backend\models\Unit::findName(\backend\models\Product::findProductInfo($query[$i]['product_id'])->unit_id)?>
                            </td>
                            <td style="vertical-align: middle;text-align: right;background-color: #1b6d85;color: white">
<?=number_format((float)$query[$i]['qty'] * (float)$query[$i]['price'],2);?>
                            </td>
                            <td style="vertical-align: middle">
                                <?=$query[$i]['transport_in_no']?>
                            </td>
                            <td style="vertical-align: middle">
                                <?=date('d-m-Y',strtotime($query[$i]['transport_in_date']))?>
                            </td>
                            <td style="text-align: center;vertical-align: middle">
                                <?=$query[$i]['sequence']?>
                            </td>

                            <td style="vertical-align: middle">
                                <input type="text" style="width: 200px;" class="form-control" name="" readonly value="  <?=\backend\models\Product::findGeo($query[$i]['product_id'])?>">
                            </td>

                            <td style="text-align: center;vertical-align: middle">
                                <?=$query[$i]['origin']?>
                            </td>
                            <td style="vertical-align: middle">
                                <input type="text" class="form-control" name="line_transport_out_no[]" style="width: 100px;" value="">
                            </td>
                            <td style="vertical-align: middle">
                                <input type="date" class="form-control" name="line_transport_out_date[]" value="">
                            </td>
                            <td style="vertical-align: middle">
                                <?=$query[$i]['invoice_no']?>
                            </td>
                            <td style="vertical-align: middle">
                                <?=date('d-m-Y',strtotime($query[$i]['invoice_date']))?>
                            </td>
                            <td style="vertical-align: middle">
                                <input type="text" class="form-control" name="line_amount[]" style="width: 100px;" value="<?=number_format((float)$query[$i]['qty'] * (float)$query[$i]['price'],2);?>">
                            </td>
                            <td style="vertical-align: middle">
                                <?=$query[$i]['permit_no']?>
<!--                                <input type="text" style="width: 200px;" class="form-control line_permit_no" name="line_permit_no[]" value="">-->
                            </td>
                            <td style="vertical-align: middle">
<!--                                <input type="date" class="form-control" name="permit_date[]" value=" --><?//=date('d-m-Y',strtotime($query[$i]['permit_date']))?><!--">-->
                                <?=date('d-m-Y',strtotime($query[$i]['permit_date']))?>
                            </td>
                            <td style="vertical-align: middle">
                                <input type="text" style="width: 200px;" class="form-control line_kno_out" name="line_kno_out_no[]" value="">
                            </td>
                            <td style="vertical-align: middle">
                                <input type="date" class="form-control" name="line_kno_out_date[]" value="">
                            </td>
                        </tr>
                      <?php endfor;?>
                    <?php endif;?>
                </tbody>
            </table>
            <br>
            <div class="btn btn-success btn-ok"> บันทึก</div>
            </form>
        </div>
    </div>
</div>


<div id="packModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="text-primary"><i class="fa fa-plus-circle"></i> เลือกรายการ</h3>
            </div>
            <div class="modal-body">
                <form id="form-picking2" action="<?=Url::to(['sale/createpicking'],true)?>" method="post">
                    <input type="hidden" name="sale_id" class="sale-id" value="">
                    <table class="table table-bordered table-striped table-picking">
                        <thead>
                        <tr>
                            <th>เลขที่ใบนำเข้า</th>
                            <th>วันที่</th>
                            <th>ใบอนุญาต</th>
                            <th>วันที่</th>
                            <th>จำนวน</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close text-danger"></i> ปิดหน้าต่าง</button>
            </div>
        </div>

    </div>
</div>
<?php
$url_to_findpack = Url::to('sale/findpack');
$js=<<<JS
    $(function() {
     // $("#packModal").modal("show");
     $(".btn-ok").click(function(){
         $("#form-packing").submit();
     });
    });
    function finditem(e) {
        $.ajax({
              'type':'post',
              'dataType': 'json',
              'url': "$url_to_findpack",
              'data': {'txt': "*"},
              'success': function(data) {
                // alert(data);return;
            
                     var html = "";
                     for(var i =0;i<=data.length -1;i++){
                         html +="<tr ondblclick='getitem($(this));'><td style='vertical-align: middle'>"+
                         data[i]['engname']+"</td><td style='vertical-align: middle'>"+
                         data[i]['name']+"<input type='hidden' class='recid' value='"+data[i]['id']+"'/>" +
                          "<input type='hidden' class='prodcost' value='"+data[i]['cost']+"'/>" +
                          "<input type='hidden' class='prodprice' value='"+data[i]['price']+"'/>" +
                           "</td>"+
                           "<td>"+data[i]['origin']+"</td>"+
                           "<td style='vertical-align: middle;text-align: center'><div class='btn btn-info btn-sm' onclick='getitem($(this));'>เลือก</div></td></tr>"
                     }
                     $(".table-list tbody").html(html);
                     
              }
            });
      $("#packModal").modal("show");
    }
JS;
$this->registerJs($js,static::POS_END);
?>


