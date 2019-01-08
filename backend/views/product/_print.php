<?php
//use barcode\barcode\BarcodeGenerator as BarcodeGenerator;
//
//$optionsArray = array(
//    'elementId'=> 'showBarcode', /* div or canvas id*/
//    'value'=> '4797001018719', /* value for EAN 13 be careful to set right values for each barcode type */
//    'type'=>'code39',/*supported types  ean8, ean13, upc, std25, int25, code11, code39, code93, code128, codabar, msi, datamatrix*/
//
//);
//echo BarcodeGenerator::widget($optionsArray);
$this->title = "พิมพ์บาร์โค้ดรหัสสินค้า";

?>

<!--<div id="showBarcode"></div>-->
<?php foreach($list as $data):?>
<div class="product-sectionx">
  <h3>บาร์โค้ดรหัสสินค้า [ <?=$data->product_code;?> <?=$data->name;?> ] จำนวน <?=number_format($barcode_qty,0)?> ชุด </h3>
</div>
   <?php for($i=0;$i<=$barcode_qty-1;$i++):?>

    <div class="label"> <?=$show_code==0?$data->product_code:''?><br><barcode code="<?=$data->product_code?>" type="c39" size="0.8" height="2.0"/><br>
    <?=$show_name==0?$data->name:''?></div>

   <?php endfor;?>
    <div class="page-break"></div>
<?php endforeach;?>






