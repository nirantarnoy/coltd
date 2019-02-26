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
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>รายการสินค้า</th>
                        <th>จำนวน</th>
                        <th>เลขที่ใบนำเขา้</th>
                        <th>วันที่</th>
                        <th>พิกัด</th>
                        <th>ใบขนขาออก</th>
                        <th>invoice/date</th>
                        <th>ใบอนุญาต</th>
                        <th>วันที่</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($modelline)):?>
                    <?php $i=0; ?>
                      <?php foreach($modelline as $value):?>
                            <?php $i+=1; ?>
                        <tr>
                            <td>
                                <?=$i?>
                            </td>
                            <td>
                                <?=\backend\models\Product::findEng($value->product_id)?>
                                <input type="hidden" name="product_id[]" class="productid" value="<?=$value->product_id?>" >
                            </td>
                            <td>
                                <input type="number" class="form-control line_qty" value="<?=$value->qty?>">
                            </td>
                            <td>
                                <input type="text" class="form-control line_transport_in" name="line_transport_in_no[]" value="" ondblclick="finditem($(this))">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="" value="" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="" readonly value="  <?=\backend\models\Product::findGeo($value->product_id)?>">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="" value="">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="" value="">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="" value="">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="" value="" readonly>
                            </td>
                        </tr>
                      <?php endforeach;?>
                    <?php endif;?>
                </tbody>
            </table>
            <br>
            <div class="btn btn-success"> บันทึก</div>
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
                <form id="form-picking" action="<?=Url::to(['sale/createpicking'],true)?>" method="post">
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


