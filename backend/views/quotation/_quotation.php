<?php
/**
 * Created by PhpStorm.
 * User: niran.w
 * Date: 07/02/2019
 * Time: 13:24:38
 */
?>
<div class="row" style="font-family: angsana;">
<!--    <h1>สวัสดี</h1>-->
    <div class="col-lg-12">

        <table class="table" border="0" style="width: 100%;border-collapse: collapse;">
            <thead>
            <tr colspan="">
                <td colspan="11" style="text-align: center">
                    <img src="<?= \yii\helpers\Url::to('@web/uploads/images/logo.png', true) ?>" width="20%" alt="logo" /><br>
                </td>
            </tr>
            <tr colspan="4">
                <td colspan="11" style="text-align: center">
                    <small>230 CHALONGKRUNG LUMPRATIEW LATKRABANG BANGKOK 10520 THAILAND</small>
                    <br>
                    <h4 style="color: #0d69af">
                        <u>
                            TEL :02-7397298,02-7397188  FAX: 02-7397189 EMAIL:  JLD_BEV@OUTLOOK.COM
                        </u>
                    </h4>
                    <br>
                    <small>CO. REG. NO. : 0105557061401</small>
                </td>
            </tr>
            <tr rowspan="7"></tr>
            <tr colspan="7">
                <td colspan="8" style="text-align: center;font-size: 14px;font-weight: bold;border: none;">

                </td>
                <td colspan="3" style="text-align: right;font-size: 13px;font-weight: bold;border: none;">

                </td>
            </tr><br>
            <tr colspan="7">
                <td colspan="8" style="text-align: center;font-size: 14px;font-weight: bold;border: none;">

                </td>
                <td colspan="3" style="text-align: right;font-size: 13px;font-weight: bold;border: none;">

                </td>
            </tr><br><br>
            <tr >
                <td colspan="2" style="border: none;font-size: 14px;font-weight: bold">Prepared For: </td>
                <td colspan="5" style="border: none;font-size: 14px;font-weight: bold">

                </td>

                <td colspan="2" style="text-align: right;font-size: 13px;font-weight: bold;border: none;">
                    Date: <?=date('d/m/Y',$model->require_date)?><br />
                    Invoice: <?=$model->quotation_no?>
                </td>
            </tr>
            <tr >
                <td colspan="1" style="border: none;font-size: 14px;font-weight: bold"></td>
                <td colspan="3" style="border: none;font-size: 13px;">
                    <?=\backend\models\Customer::findInfo($model->customer_id)->name?> <br>
                    <?=\backend\models\Customer::findInfo($model->customer_id)->address?>
                </td>

                <td colspan="2" style="text-align: right;font-size: 13px;font-weight: bold;border: none;">

                </td>
            </tr>
            <tr >
                <td colspan="1" style="border: none;font-size: 14px;font-weight: bold"></td>
                <td colspan="4" style="border: none;font-size: 14px;font-weight: normal">

                </td>
            </tr> <br> <br>
            </thead>
            <tbody style="top: 10px;">
            <tr>
                <td colspan="11" style="text-align: center;font-size: 16px;font-weight: bold;">ใบเสนอราคา</td>
            </tr>
            <tr style="background: #c3c3c3;" rowspan="2">
                <td  style="padding: 10px;border: 0.2px solid grey;border-bottom: 0px;font-size: 14px;font-weight: bold;text-align: center;width: 9%">No.</td>
                <td  style="padding: 10px;border: 0.2px solid grey;border-bottom: 0px;font-size: 14px;font-weight: bold;text-align: center;width: 9%"></td>
                <td  style="padding: 10px;border: 0.2px solid grey;border-bottom: 0px;font-size: 14px;font-weight: bold;text-align: center;width: 9%">Code</td>
                <td  style="border: 0.2px solid grey;border-bottom: 0px;font-size: 14px;font-weight: bold;text-align: center">Description</td>
                <td  style="padding: 5px;border: 0.2px solid grey;border-bottom: 0px;font-size: 14px;font-weight: bold;text-align: center">Qty</td>
                <td  style="border: 0.2px solid grey;border-bottom: 0px;font-size: 14px;font-weight: bold;text-align: center">Origin</td>
                <td  colspan="3" style="border: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: center">Packing</td>
                <td  style="border: 0.2px solid grey;border-bottom: 0px;font-size: 14px;font-weight: bold;text-align: center;width: 15%">Price</td>
                <td  style="border: 0.2px solid grey;border-bottom: 0px;font-size: 14px;font-weight: bold;text-align: center;width: 15%">Total</td>
            </tr>
            <tr style="background: #c3c3c3; row-span: 2">
                <td  style="padding: 10px;border-left: 0.2px solid grey;"></td>
                <td  style="border-left: 0.2px solid grey;font-size: 12px;font-weight: bold;text-align: center"></td>
                <td  style="border-left: 0.2px solid grey;font-size: 12px;font-weight: bold;text-align: center"></td>
                <td  style="border-left: 0.2px solid grey;font-size: 12px;font-weight: bold;text-align: center"></td>
                <td  style="border-left: 0.2px solid grey;font-size: 13px;font-weight: bold;text-align: center"></td>
                <td  style="border-left: 0.2px solid grey;font-size: 13px;font-weight: bold;text-align: center">Country</td>
                <td  style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: center">Bottle</td>
                <td  style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: center">Litre</td>
                <td  style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: center">Alkohol</td>
                <td  style="border-left: 0.2px solid grey;font-size: 13px;font-weight: bold;text-align: center;width: 15%"></td>
                <td  style="border-left: 0.2px solid grey;border-right: 0.2px solid grey;font-size: 13px;font-weight: bold;text-align: center;width: 15%"></td>
            </tr>
            <?php $rows = 0; ?>
            <?php $sumqty = 0; ?>
            <?php $sumnet = 0; ?>
            <?php $sumtotal = 0; ?>
            <?php foreach ($modelline as $value):?>
                <?php
                $sumqty = $sumqty + $value->qty;
                //$sumnet = $sumnet + \backend\models\Product::findProductinfo($value->product_id)->netweight;
                $sumtotal = $sumtotal + $value->qty * $value->price;
                $url = '../web/uploads/images/'.\backend\models\Productimage::getCover($value->product_id);
                $photo = "<img src=".$url." width='10%' >";
                ?>
                <?php $rows +=1; ?>
                <tr style="border: 0.5px solid black;border-bottom:none;border-collapse: collapse;">
                    <td style="padding: 5px;font-size: 12px;font-weight: normal;text-align: center;"><?=$rows?></td>
                    <td style="border-left: 0.2px solid grey;text-align: center"><?=$photo?></td>
                    <td style="border-left: 0.2px solid grey;font-size: 12px;font-weight: normal;padding-left: 5px;text-align: center"><?=\backend\models\Product::findProductinfo($value->product_id)->product_code;?></td>
                    <td style="border-left: 0.2px solid grey;font-size: 12px;font-weight: normal;padding-left: 5px;text-align: left"><?=\backend\models\Product::findProductinfo($value->product_id)->engname;?></td>
                    <td style="border-left: 0.2px solid grey;font-size: 12px;font-weight: normal;text-align: center;padding-right: 10px;"><?=number_format($value->qty,0)?></td>
                    <td style="border-left: 0.2px solid grey;font-size: 12px;font-weight: normal;text-align: center;padding-right: 10px;"><?=\backend\models\Product::findProductinfo($value->product_id)->origin;?></td>
                    <td style="border-left: 0.2px solid grey;font-size: 12px;font-weight: normal;text-align: center;padding-right: 10px;"><?=\backend\models\Product::findProductinfo($value->product_id)->unit_factor;?></td>
                    <td style="border-left: 0.2px solid grey;font-size: 12px;font-weight: normal;text-align: center;padding-right: 10px;"><?=\backend\models\Product::findProductinfo($value->product_id)->volumn;?></td>
                    <td style="border-left: 0.2px solid grey;font-size: 12px;font-weight: normal;text-align: center;padding-right: 10px;"><?=\backend\models\Product::findProductinfo($value->product_id)->volumn_content.'%';?></td>
                    <td style="border-left: 0.2px solid grey;font-size: 12px;font-weight: normal;text-align: center;padding-right: 10px;"><?=number_format($value->price,0)?></td>

                    <td style="border-left: 0.2px solid grey;font-size: 12px;font-weight: normal;text-align: center;padding-right: 10px;"><?=number_format($value->qty * $value->price,0)?></td>

                </tr>
            <?php endforeach; ?>
            <?php if($rows < 20): ?>
                <?php for($x=0;$x<=(20-$rows)-1;$x++): ?>
                    <tr style="border: 0.1px solid black;border-top: none;border-bottom:none;">
                        <td style="padding: 5px;font-size: 14px;font-weight: bold;text-align: left;"></td>
                        <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: left"></td>
                        <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: left"></td>
                        <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;padding-right: 10px;"></td>
                        <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;padding-right: 10px;"></td>
                        <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;padding-right: 10px;"></td>
                        <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;padding-right: 10px;"></td>
                        <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;padding-right: 10px;"></td>
                        <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;padding-right: 10px;"></td>
                        <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;padding-right: 10px;"></td>
                        <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right;padding-right: 10px;"></td>
                    </tr>
                <?php endfor; ?>
            <?php endif; ?>

            <?php //for($x=0;$x<=(20-$rows)-1;$x++): ?>
            <!--            <tr style="border: 1px solid black;">-->
            <!--                <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: left;height: 10px;"></td>-->
            <!--                <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: left"></td>-->
            <!--                <td style="border-left: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right"></td>-->
            <!--                <td style="border-left: 0.2px solid grey;border-right: 0.2px solid grey;font-size: 14px;font-weight: bold;text-align: right"></td>-->
            <!--            </tr>-->
            <?php //endfor; ?>
            <tr style="border: 1px solid black;border-left:none;border-right: none ">
                <!--            <tr>-->
                <td style="padding: 15px 15px 15px 15px;font-size: 14px;font-weight: bold;text-align: left" colspan="4">TOTAL</td>

                <td style="text-align: center;font-size: 14px;font-weight: bold"><?=number_format($sumqty,0)?></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="font-size: 14px;font-weight: normal;text-align: center;padding-right: 10px;"></td>
                 <td style="font-size: 14px;font-weight: normal;text-align: center;padding-right: 10px;"></td>
                <td style="font-size: 14px;font-weight: bold;text-align: center;padding-right: 10px;"><?=number_format($sumtotal,0)?></td>

            </tr>

            </tbody>

        </table>
        <br><br>
        <table width="100%">
            <tr>
                <td colspan="6" style="text-align: center">
                    <small>230 CHALONGKRUNG LUMPRATIEW LATKRABANG BANGKOK 10520 THAILAND</small>
                    <br>
                    <h4 style="color: #0d69af">
                        <u>
                            TEL :02-7397298,02-7397188  FAX: 02-7397189 EMAIL:  JLD_BEV@OUTLOOK.COM
                        </u>
                    </h4>
                    <br>
                    <small>CO. REG. NO. : 0105557061401</small>
                </td>
            </tr>
        </table>

    </div>
</div>
