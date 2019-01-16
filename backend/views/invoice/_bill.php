<?php
use yii\helpers\Html;
$this->registerJsFile( '@web/js/ThaiBath-master/thaibath.js',
    ['depends' => [\yii\web\JqueryAsset::className()]],
    static::POS_HEAD
);
?>
<table width="100%">
    <tr>
        <td width="70%">
            <h3><?=$supinfo->name?></h3><br>
            <h4>เลขประจำตัวผู้เสียภาษี : <?=$supinfo->id_card?></h4><br>
            <h4>ที่อยู่ : <?=$supaddress?></h4><br>
        </td>
        <td width="30%">
            <table class="po-vendor">
                <tr>
                    <td>
                        <h2>ใบเสร็จรับเงิน</h2>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
<hr>
<table width="100%">
    <tr>
        <td width="70%">
            <h3>ชื่อลูกค้า : <?=$comname?></h3><br>
            <h4>เลขประจำตัวผู้เสียภาษี : <?=$comtax?></h4><br>
            <h4>ที่อยู่ : <?=$comaddress?></h4><br>
        </td>
        <td width="30%">
            <h3>วันที่ : <?=date('d/m/Y')?></h3><br>
            <h4>เลขที่ : <?=$invoice_no?></h4><br>
            <h4>เบอร์โทรศัพท์ : <?=$comtel?></h4><br>
        </td>
    </tr>
</table>




<table class="table_bordered" width="100%">
    <tbody>
                <tr style="background: #c3c3c3">
                    <td style="border: none;font-size: 12px;font-weight: bold;text-align: center">วันที่</td>
                    <td style="border: none;font-size: 12px;font-weight: bold;text-align: center">เลขบิล</td>
                    <td style="border: none;font-size: 12px;font-weight: bold;text-align: center">ขื่อผู้ส่ง</td>
                    <td style="border: none;font-size: 12px;font-weight: bold;text-align: center">ประเภทสินค้า</td>
                    <td style="border: none;font-size: 12px;font-weight: bold;text-align: center">จำนวนส่ง(ลูก)</td>
                    <td style="border: none;font-size: 12px;font-weight: bold;text-align: center">หัก(ลูก)</td>
                    <td style="border: none;font-size: 12px;font-weight: bold;text-align: center">จำนวนจ่าย(ลูก)</td>
                    <td style="border: none;font-size: 12px;font-weight: bold;text-align: center">ราคา</td>
                    <td style="border: none;font-size: 12px;font-weight: bold;text-align: center">จำนวนเงินจ่าย(บาท)</td>
                    <td style="border: none;font-size: 12px;font-weight: bold;text-align: center">หมายเหตุ</td>
                </tr>
    <?php if(count($invoice_line)>0):?>
        <?php foreach($invoice_line as $value):?>
            <tr style="background: #fff">
                <td style="border: none;font-size: 12px;font-weight: bold;text-align: center"><?=date('d/m/Y',$value->trans_date_ref)?></td>
                <td style="border: none;font-size: 12px;font-weight: bold;text-align: center">-</td>
                <td style="border: none;font-size: 12px;font-weight: bold;text-align: center">-</td>
                <td style="border: none;font-size: 12px;font-weight: bold;text-align: center"><?= \backend\models\Product::findName($value->product_id)?></td>
                <td style="border: none;font-size: 12px;font-weight: bold;text-align: center"><?=number_format($value->qty)?></td>
                <td style="border: none;font-size: 12px;font-weight: bold;text-align: center">0</td>
                <td style="border: none;font-size: 12px;font-weight: bold;text-align: center"><?=number_format($value->qty)?></td>
                <td style="border: none;font-size: 12px;font-weight: bold;text-align: center"><?=number_format($value->price)?></td>
                <td style="border: none;font-size: 12px;font-weight: bold;text-align: center"><?=number_format($value->qty * $value->price)?></td>
                <td style="border: none;font-size: 12px;font-weight: bold;text-align: center"></td>
            </tr>
        <?php endforeach;?>
            <tr style="background: #fff;">
                <td colspan="8" style="border-top: 0.8px solid gray;border-bottom: none;border-right: none;border-left: none;font-size: 12px;font-weight: bold;text-align: right;padding: 10px;">รวมเป็นเงิน</td>
                <td style="border-top: 0.8px solid gray;border-bottom: none;border-right: none;border-left: none;font-size: 12px;font-weight: bold;text-align: center">
                    <span><?=number_format($amount,0)?></span>
                </td>
                <td style="border-top: 0.8px solid gray;border-bottom: none;border-right: none;border-left: none;font-size: 12px;font-weight: bold;text-align: center"></td>
            </tr>
        <tr style="background: #fff">
            <td colspan="8" style="border: none;font-size: 12px;font-weight: bold;text-align: right;padding: 10px;">หักเบิกวัสดุ</td>
            <td style="border: none;font-size: 12px;font-weight: bold;text-align: center">
                <span><?=number_format($total_issue,0)?></span>
            </td>
            <td style="border: none;font-size: 12px;font-weight: bold;text-align: center"></td>
        </tr>
        <tr style="background: #fff">
            <td colspan="8" style="border: none;font-size: 12px;font-weight: bold;text-align: right;padding: 10px;">หักเบิกล่วงหน้า</td>
            <td style="border: none;font-size: 12px;font-weight: bold;text-align: center"></td>
            <td style="border: none;font-size: 12px;font-weight: bold;text-align: center"></td>
        </tr>
        <tr style="background: #fff">
            <td colspan="6" style="border: none;font-size: 12px;font-weight: bold;text-align: center">
                <table class="xx" width="100%">
                    <tr>
                        <td>
                            <h3 class="money-text"><?=$total_text?></h3>
                        </td>
                    </tr>
                </table>
            </td>

            <td colspan="2" style="border: none;font-size: 12px;font-weight: bold;text-align: right;padding: 10px;">ยอดรวมสุทธิ</td>
            <td style="border: none;font-size: 12px;font-weight: bold;text-align: center">
                <span class="grandtotal"><?=number_format($total_amount,0)?></span>
            </td>
            <td style="border: none;font-size: 12px;font-weight: bold;text-align: center"></td>
        </tr>

    <?php endif;?>
    </tbody>

</table>

<?php
$js =<<<JS
   $(function() {
      var numtext = $(".grandtotal").text(); 
      alert(numtext);
      var txt = ArabicNumberToText(numtext);
      $(".money-text").text(txt);
   });
JS;
$this->registerJs($js,static::POS_END);
?>