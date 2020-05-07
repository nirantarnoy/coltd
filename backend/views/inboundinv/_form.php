<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\helpers\Url;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Inboundinv */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inboundinv-form">

    <?php $form = ActiveForm::begin(['id' => 'form-inbound']); ?>
    <div class="panel panel-body">
        <div class="row">
            <div class="col-lg-4">
                <?= $form->field($model, 'invoice_no')->textInput(['maxlength' => true, 'readonly' => 'readonly', 'value' => $model->isNewRecord ? $runno : $model->invoice_no]) ?>
            </div>
            <div class="col-lg-4">
                <?php $model->invoice_date = $model->isNewRecord ? date('d/m/Y') : date('d/m/Y', strtotime($model->invoice_date)); ?>
                <?= $form->field($model, 'invoice_date')->widget(DatePicker::className(), [
                    'value' => date('d/m/Y'),
                    'options' => ['id' => 'invoice_date', 'class' => 'inbound_date'],
                    'pluginOptions' => [
                        'format' => 'dd/mm/yyyy',
                        'todayHighlight' => true,
                        'todayBtn' => true,
                    ]
                ]) ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'customer_ref')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <!--            <div class="col-lg-4">-->
            <!--                --><?php ////echo $form->field($model, 'delivery_term')->textInput(['maxlength' => true]) ?>
            <!--            </div>-->
            <div class="col-lg-4">
                <?php $xstatus = $model->isNewRecord ? 'open' : \backend\helpers\QuotationStatus::getTypeById($model->status); ?>
                <?= $form->field($model, 'status')->textInput(['value' => $xstatus, 'readonly' => 'readonly']) ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'docin_no')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'supplier_id')->widget(\kartik\select2\Select2::className(), [
                    'data' => ArrayHelper::map(\backend\models\Vendor::find()->all(), 'id', 'name'),
                    'options' => [
                        'placeholder' => 'เลือก',
                        'id' => 'supplier_id',
                    ]
                ])->label('ผู้ขาย') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <?= $form->field($model, 'currency_id')->widget(Select2::className(), [
                    'data' => ArrayHelper::map(\backend\helpers\Currency::asArrayObject(), 'id', 'name'),
                    'options' => [
                        'placeholder' => 'เลือกสกุลเงิน',
                        'onchange' => 'checkRate($(this))',
                        'class' => 'selected-currency'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ])->label('สกุลเงิน') ?>
                <div class="text-danger alert-currency" style="display: none"></div>
            </div>
            <div class="col-lg-3">
                <label for="">อัตราแลกเปลี่ยน</label>
                <!--                <input type="text" class="form-control rate" name="rate" readonly value="">-->
                <?= $form->field($model, 'currency_rate')->textInput(['class' => 'form-control rate', 'readonly' => 'readonly'])->label(false) ?>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered table-quotation">
                    <thead>
                    <tr style="background-color: #00afe1;color: #ffffff">
                        <th style="width: 5%">#</th>
                        <th style="width: 5%">รูป</th>
                        <th>รหัสสินค้า</th>
                        <th>รายละเอียด</th>
                        <th style="width: 10%">จำนวน</th>
                        <th style="width: 10%">origin</th>
                        <th>ปริมาณ/ลัง</th>
                        <th>ลิตร/ขวด</th>
                        <th>%</th>

                        <th>ราคา</th>
                        <th>รวม</th>
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
                                <input type="hidden" class="stock-id" name="stock_id[]" value="">
                                <input type="text" autocomplete="off" class="form-control productcode" name="prodcode[]"
                                       value="" onchange="itemchange($(this));" ondblclick="showfind($(this))">
                            </td>
                            <td>
                                <input type="text" class="form-control productname" name="prodname[]" value="" readonly>
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
                                <input type="text" class="form-control line_packper" value="" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control line_litre" value="" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control line_percent" value="" readonly>
                            </td>

                            <td>
                                <input type="hidden" name="line_price_origin" class="line-price-origin" value="">
                                <input type="hidden" name="line_price_origin" class="line-price-origin-thb" value="">
                                <input style="text-align: right" type="text" class="form-control line_price"
                                       name="price[]" value="" onchange="cal_num($(this));">
                            </td>
                            <td>
                                <input style="text-align: right" type="text" class="form-control line_total"
                                       name="linetotal[]" value="" readonly>
                            </td>
                            <td>
                                <div class="btn btn-sm btn-danger btn-removeline" onclick="return removeline($(this));">
                                    <i class="fa fa-trash-o"></i></div>
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
                                        <input type="hidden" class="stock-id" name="stock_id[]"
                                               value="<?php //echo $value->stock_id?>">
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
                                        <input type="number" min="0" class="form-control line_qty" name="qty[]"
                                               value="<?= $value->line_qty ?>" onchange="cal_num($(this));">
                                    </td>
                                    <td>
                                        <!--                                            <input type="text" class="form-control line_cost" name="cost[]" value="" readonly>-->
                                        <input type="text" class="form-control line_origin" name="origin[]"
                                               value="<?= \backend\models\Product::findProductinfo($value->product_id) != null ? \backend\models\Product::findProductinfo($value->product_id)->origin : '' ?>"
                                               readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control line_packper"
                                               value="<?= \backend\models\Product::findProductInfo($value->product_id)->unit_factor ?>"
                                               readonly>
                                    </td>

                                    <td>
                                        <input type="text" class="form-control line_percent"
                                               value="<?= \backend\models\Product::findProductInfo($value->product_id)->volumn ?>"
                                               readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control line_litre"
                                               value="<?= \backend\models\Product::findProductInfo($value->product_id)->volumn_content ?>"
                                               readonly>
                                    </td>
                                    <td>
                                        <input type="hidden" name="line_price_origin" class="line-price-origin"
                                               value="">
                                        <input type="hidden" name="line_price_origin_thb"
                                               class="line-price-origin-thb"
                                               value="<?= \backend\models\Product::findProductinfo($value->product_id)->price_carton_thb ?>">
                                        <input type="hidden" name="line_price_origin_thb_origin"
                                               class="line-price-origin-thb-origin"
                                               value="<?= \backend\models\Product::findProductinfo($value->product_id)->price_carton_thb ?>">

                                        <input style="text-align: right" type="text" class="form-control line_price"
                                               name="price[]" value="<?= $value->line_price ?>"
                                               onchange="cal_num($(this));">
                                    </td>
                                    <td>
                                        <input style="text-align: right" type="text" class="form-control line_total"
                                               name="linetotal[]" value="<?= $value->line_price * $value->line_qty ?>"
                                               readonly>
                                    </td>
                                    <td>
                                        <div class="btn btn-sm btn-danger btn-removeline"
                                             onclick="return removeline($(this));"><i class="fa fa-trash-o"></i></div>
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
                                    <input type="number" min="0" class="form-control line_qty" name="qty[]" value=""
                                           onchange="cal_num($(this));">
                                </td>
                                <td>
                                    <!--                                        <input style="text-align: right" type="text" class="form-control line_cost" name="cost[]" value="" readonly>-->
                                    <input style="text-align: right" type="text" class="form-control line_origin"
                                           name="origin[]" value="" readonly>
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
                        <?php endif; ?>

                    <?php endif; ?>
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
    </div>

    <div class="form-group pull-right">
        <?= Html::submitButton("<i class='fa fa-save'></i> บันทึก", ['class' => 'btn btn-success']) ?>
        <?php if (!$model->isNewRecord): ?>

            <?= Html::Button("<i class='fa fa-print'></i> พิมพ์ Invoice", ['class' => 'btn btn-warning btn-quote-print', 'data-id' => $model->id]) ?>
            <?= Html::Button("<i class='fa fa-print'></i> พิมพ์ Packing", ['class' => 'btn btn-info btn-quote-print-packing', 'data-id' => $model->id]) ?>
            <?php //echo Html::Button("<i class='fa fa-print'></i> พิมพ์ PackingList", ['class' => 'btn btn-primary btn-firm-sale']) ?>
            <?= Html::a('สร้าง Form นำเข้า', ['inboundinv/createtrans', 'id' => $model->id], ['class' => 'btn btn-default']) ?>


        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>
    <br>
    <br>
    <div class="panel panel-body">
        <b>เอกสารประกอบการนำเข้า</b>
        <br>
        <form action="<?= Url::to(['inboundinv/attachfile'], true) ?>" method="post" enctype="multipart/form-data">
            <br>
            <div class="row">
                <div class="col-lg-6">
                    <input type="hidden" name="inv_id" value="<?= $model->id ?>">
                    <input type="file" name="doc_file" class="form-control">
                </div>
                <div class="col-lg-6">
                    <input type="submit" value="บันนึกแนบไฟล์" class="btn btn-warning">
                </div>
            </div>

        </form>
        <hr>
        <div class="row">
            <div class="col-lg-6">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>วันที่</th>
                        <th>เอกสาร</th>
                        <th>-</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (count($modeldoc) > 0): ?>
                        <?php foreach ($modeldoc as $val): ?>
                            <tr>
                                <td><?= date('d/m/Y', $val->created_at) ?></td>
                                <td>
                                    <a href="<?= Yii::$app->getUrlManager()->baseUrl ?>/uploads/doc_in/<?= $val->filename ?>"
                                       target="_blank">
                                        <?= $val->filename ?>
                                    </a>
                                </td>
                                <td>
                                    <input type="hidden" class="doc_line_id" name="doc_line_id" value="<?= $val->id ?>">
                                    <i class="fa fa-trash" onclick="removedoc($(this))"></i>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <br>
    <div class="panel">
        <div class="panel panel-heading">
            <h3><i class="fa fa-clock-o"></i> ประวัติชำระเงิน</h3>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>วันที่</th>
                    <th>จำนวน</th>
                    <th>Note</th>
                    <th>slip</th>
                    <th>-</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!$model->isNewRecord): ?>
                    <?php if (count($modelpayment) > 0): ?>
                        <?php $i = 0; ?>
                        <?php foreach ($modelpayment as $value): ?>
                            <?php $i += 1; ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $value->trans_date ?></td>
                                <td><?= $value->amount ?></td>
                                <td><?= $value->note ?></td>
                                <td>
                                    <a href="../web/uploads/slip/<?= trim($value->slip) ?>"
                                       target="_blank"><?= trim($value->slip) ?></a>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="hidden" class="trans-date" value="<?= $value->trans_date ?>">
                                        <input type="hidden" class="trans-time" value="<?= $value->trans_time ?>">
                                        <input type="hidden" class="trans-amount" value="<?= $value->amount ?>">
                                        <input type="hidden" class="trans-note" value="<?= $value->note ?>">
                                        <input type="hidden" class="trans-file" value="<?= $value->trans_date ?>">
                                        <div class="btn btn-warning" data-id="<?= $value->id ?>"
                                             onclick="editpay($(this))">แก้ไข
                                        </div>
                                        <div class="btn btn-danger" data-id="<?= $value->id ?>"
                                             onclick="deletepay($(this))">ลบ
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <form id="form-print-invoice" action="<?= Url::to(['inboundinv/printinv', 'id' => $model->id], true) ?>"
          method="post" target="_blank"></form>
    <form id="form-print-packing" action="<?= Url::to(['inboundinv/print', 'id' => $model->id], true) ?>" method="post"
          target="_blank"></form>
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
                <div class="wmd-view-topscroll" style=" overflow-x: scroll;overflow-y: hidden;width: 100%;">
                    <div id="div1" style="width: 2000px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                </div>
                <div class="wmd-view" style="overflow-x: scroll;overflow-y: hidden;width: 100%;;white-space:nowrap;">
                    <div style="display: inline-block;">
                        <input type="hidden" name="line_qc_product" class="line_qc_product" value="">
                        <table class="table table-bordered table-striped table-list">
                            <thead>
                            <tr>
                                <th style="text-align: center">เลือก</th>
                                <th>รหัสสินค้า</th>
                                <th>รายละเอียด</th>
                                <th>ขวด/ลัง</th>
                                <th>สิตร/ขวด</th>
                                <th>แอลกอฮอร์ %</th>
                                <th>พิกัด</th>
                                <th>ชนิดสินค้า</th>
                                <th>ประเทศ</th>
                                <th>เลข28หลัก</th>
                                <th>วันที่เลข28หลัก</th>
                                <th>ราคาขายปลีก</th>

                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i
                            class="fa fa-close text-danger"></i> ปิดหน้าต่าง
                </button>
            </div>
        </div>

    </div>
</div>

<div id="paymentModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-tags"></i> บันทึกชำระเงิน
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <form id="form-payment" action="<?= Url::to(['inboundinv/updatepaymenttrans'], true) ?>" method="post"
                      enctype="multipart/form-data">
                    <input type="hidden" name="recid" class="recid" value="">
                    <input type="hidden" name="saleid" class="saleid" value="<?= $model->id ?>">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">ยอดเต็มที่ต้องชำระ</label>
                            <input type="hidden" class="hidden-amount" value="<?= $model->total_amount ?>">
                            <input type="text" class="form-control total-amount" name="total_amount"
                                   value="<?= number_format($model->total_amount) ?>" readonly>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">วันที่</label>
                            <?php
                            echo DatePicker::widget([
                                'name' => 'payment_date',
                                'options' => ['id' => 'trans-date'],
                                'value' => date('Y/m/d'),
                            ])
                            ?>
                        </div>

                        <div class="col-lg-6">
                            <label for="">จำนวนเงิน</label>
                            <input type="text" id="trans-amount" class="form-control payment-amount" name="amount"
                                   value=""
                                   onchange="checkamount($(this))">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-6">
                            <label class="control-label">เวลา</label>
                            <?php echo TimePicker::widget(['name' => 'payment_time', 'options' => ['id' => 'trans-time']]); ?>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Notes</label>
                            <textarea name="note" id="trans-note" class="form-control" id="" cols="30"
                                      rows="3"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">แนบหลักฐาน</label>
                            <input type="file" id="trans-file" name="payment_slip">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-payment" data-dismiss="modalx"><i
                            class="fa fa-close text-danger"></i> บันทึกรายการ
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i
                            class="fa fa-close text-danger"></i> ปิดหน้าต่าง
                </button>
            </div>
        </div>

    </div>
</div>


<form id="form-payment-delete" action="<?= Url::to(['inboundinv/deletepaymenttrans'], true) ?>" method="post">
    <input type="hidden" name="recid_delete" class="recid-delete" value="">
    <input type="hidden" name="inbound_id" value="<?= $model->id ?>">
</form>

<?php
$url_to_find = Url::to(['inboundinv/finditem'], true);
$url_to_firm = Url::to(['inboundinv/genpacking'], true);
$url_to_find_product = Url::to(['product/searchitem'], true);
$url_to_checkrate = Url::to(['inboundinv/check-rate'], true);
$url_to_remove_file = Url::to(['inboundinv/deletedoc'], true);
$js = <<<JS
 var currow = 0;
 var  removelist = [];
 var quote = '$model->id';
 currency_name = '';
 $(function(){
     cal_all();
     
     $(".wmd-view-topscroll").scroll(function () {
            $(".wmd-view")
            .scrollLeft($(".wmd-view-topscroll").scrollLeft());
        });

        $(".wmd-view").scroll(function () {
            $(".wmd-view-topscroll")
            .scrollLeft($(".wmd-view").scrollLeft());
        });
    
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
        $("form#form-print-invoice").submit(); 
     });
      $(".btn-quote-print-packing").click(function(){
        $("form#form-print-packing").submit(); 
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
    
    
    $(".popover1").on({
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
      var selected_currency = $(".selected-currency").val();
      var rate = $(".cur_rate").val();
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
                         var in_q = data[i]['in_qty'] == null?0:data[i]['in_qty'];
                         var out_q = data[i]['out_qty'] == null?0:data[i]['out_qty'];
                         var line_price = data[i]['thb_amount'] == null?0:data[i]['thb_amount'];
                         
                         html +="<tr ondblclick='getitem($(this));'>" +
                         "<td style='vertical-align: middle;text-align: center'><div class='btn btn-info btn-sm' onclick='getitem($(this));'>เลือก</div></td>"+
                          "<td style='vertical-align: middle'>"+
                         data[i]['product_code']+"</td><td style='vertical-align: middle'>"+
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
                          "<input type='hidden' class='stock_refid' value='"+data[i]['stock_id']+"'/>" +
                          "<input type='hidden' class='stock_price' value='"+line_price+"'/>" +
                           "</td>"+
                           "<td>"+data[i]['unit_factor']+"</td>"+
                             "<td>"+data[i]['volumn']+"</td>"+
                           "<td>"+data[i]['volumn_content']+"</td>"+
                           "<td>"+data[i]['geolocation']+"</td>"+
                          "<td>"+data[i]['group_name']+"</td>"+
                          "<td>"+data[i]['origin']+"</td>"+                         
                           "<td>"+data[i]['excise_no']+"</td>" +
                           "<td>"+data[i]['excise_date']+"</td>" +
                           "<td>"+data[i]['price']+"</td>" +
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
    
    $('form#form-inbound').on('submit', function(e){
     let sup = $("#supplier_id").val();   
      if(sup <=0){
          alert("ต้องเลือกข้อมูลผู้ขายก่อนค่ะ");
         e.preventDefault();
         return false;
      }
     let x = 0;
    $(".table-quotation tbody tr").each(function() {
       // alert();
        if($(this).closest('tr').find(".productcode").val() != ''){
            x+=1;
        }
      });
    if(x==0){
          alert("ต้องเลือกรายการสินค้าก่อนค่ะ");
      e.preventDefault();
      return false;
    }else{
        $("#form-inbound").submit();
    }
  });
    
    
    $(".btn-payment").click(function(){
       $("#form-payment").submit(); 
    });
    
 });
 function removedoc(e) {
     let lineid = e.closest('tr').find('.doc_line_id').val();
     if(lineid > 0){
           if(confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่')){
                $.ajax({
                      'type':'post',
                      'dataType': 'json',
                      'url': "$url_to_remove_file",
                      'data': {'recid': lineid},
                      'success': function(data) {
                          location.reload();
                      }
                });
          }
     }
 
 }
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
                         var in_q = data[i]['in_qty'] == null?0:data[i]['in_qty'];
                         var out_q = data[i]['out_qty'] == null?0:data[i]['out_qty'];
                         var line_price = data[i]['thb_amount'] == null?0:data[i]['thb_amount'];
                         
                         html +="<tr ondblclick='getitem($(this));'>" +
                         "<td style='vertical-align: middle;text-align: center'><div class='btn btn-info btn-sm' onclick='getitem($(this));'>เลือก</div></td>"+
                          "<td style='vertical-align: middle'>"+
                         data[i]['product_code']+"</td><td style='vertical-align: middle'>"+
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
                          "<input type='hidden' class='stock_refid' value='"+data[i]['stock_id']+"'/>" +
                          "<input type='hidden' class='stock_price' value='"+line_price+"'/>" +
                           "</td>"+
                           "<td>"+data[i]['unit_factor']+"</td>"+
                             "<td>"+data[i]['volumn']+"</td>"+
                           "<td>"+data[i]['volumn_content']+"</td>"+
                           "<td>"+data[i]['geolocation']+"</td>"+
                          "<td>"+data[i]['group_name']+"</td>"+
                          "<td>"+data[i]['origin']+"</td>"+                         
                           "<td>"+data[i]['excise_no']+"</td>" +
                           "<td>"+data[i]['excise_date']+"</td>" +
                           "<td>"+data[i]['price']+"</td>" +
                           "</tr>"
                           
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
    var prodcode = e.closest("tr").find("td:eq(1)").text();
    var prodname = e.closest("tr").find("td:eq(2)").text();
    var prodorigin = e.closest("tr").find("td:eq(8)").text()=="null"?'':e.closest("tr").find("td:eq(8)").text();
    var prodid = e.closest("tr").find(".recid").val();
    var prodcost = e.closest("tr").find(".prodcost").val();
    var prodprice = e.closest("tr").find(".prodprice").val();
    var prodprice_thb = e.closest("tr").find(".stock_price").val();
    var unitfactor = e.closest("tr").find(".unitfactor").val();
    var stock_id = e.closest("tr").find(".stock_refid").val();
    var stock_price = e.closest("tr").find(".stock_price").val();
    var volumn = e.closest("tr").find(".volumn").val();
    var volumn_content = e.closest("tr").find(".volumn_content").val();
    
    var c_rate = $(".rate").val();
    var line_price = parseFloat(c_rate) * parseFloat(prodprice);
    
    if(c_rate == ''){
        alert("กรุณาตรวจสอบ Exchange Rate");
        return;
    }
    
    //alert(volumn);
    $(".table-quotation tbody tr").each(function() {
        // if($(this).closest('tr').find(".productcode").val() == prodcode){
        //   alert("รายการสินค้านี้ซ้ำ");return false;   
       //  }
        if($(this).index() == currow){
              $(this).closest('tr').find(".productcode").val(prodcode);
              $(this).closest('tr').find(".productname").val(prodname);
              $(this).closest('tr').find(".productid").val(prodid);
              $(this).closest('tr').find(".line_qty").val(1);
              $(this).closest('tr').find(".stock-id").val(stock_id);
              $(this).closest('tr').find(".line_cost").val(prodcost);
              $(this).closest('tr').find(".line_origin").val(prodorigin);
              $(this).closest('tr').find(".line_price").val(line_price);
              $(this).closest('tr').find(".line-price-origin").val(line_price);
              $(this).closest('tr').find(".line_packper").val(unitfactor);
              $(this).closest('tr').find(".line_litre").val(volumn_content);
              $(this).closest('tr').find(".line_percent").val(volumn);
                $(this).closest('tr').find(".line-price-origin").val(prodprice);
                $(this).closest('tr').find(".line-price-origin-thb").val(prodprice_thb);
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
 function checkRate(e){
      var c_m = 0;
      var q_date = new Date();
                  var q_date_arr = $("#invoice_date").val().split('/');
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
              'async': false,
              'url': "$url_to_checkrate",
              'data': {'cur_id': id,'month': c_m},
              'success': function(data) {
                //  alert(data);
                if(data[0]!= null){
                 var exp_date = data[0]['exp_date'];
                 var rate_name = data[0]['currency'];
                 currency_name = rate_name;
                // alert(exp_date +' = '+ q_date);
                //alert(data);
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
                }else{
                     alert("ไม่พบอัตราแลกเปลี่ยน กรุณาตรวจสอบข้อมูลให้ถูกต้องด้วยครับ");
                }
                 
              }
         });
         re_cal();
     }
 }
 
 function re_cal() {
     if(currency_name == "THB"){
            $(".table-quotation tbody tr").each(function() {
                var line_price_usd =  $(this).closest('tr').find(".line-price-origin").val();
                var line_price =  $(this).closest('tr').find(".line-price-origin-thb").val();
                var new_price = parseFloat(line_price);  
                
                // if(action_mode == 1){
                //       var new_price = parseFloat(line_price) * parseFloat(line_price_usd);  
                // }else{
                //      var new_price = parseFloat(line_price) * parseFloat(line_price_usd);
                // }
                //
              
                var line_qty =  $(this).closest('tr').find(".line_qty").val();
             
                var cur_rate = $(".rate").val();
              
                var new_line_total = parseFloat(new_price) * parseFloat(line_qty);
                $(this).closest('tr').find(".line_cost").val(parseFloat(new_price).toFixed(2));
                $(this).closest('tr').find(".line_price").val(parseFloat(new_price).toFixed(2));
                $(this).closest('tr').find(".line_total").val(parseFloat(new_line_total).toFixed(2));
            });
        }else{
            $(".table-quotation tbody tr").each(function() {
                var line_price =  $(this).closest('tr').find(".line-price-origin").val();
                var line_qty =  $(this).closest('tr').find(".line_qty").val();
              
                var cur_rate = $(".rate").val();
                var new_price = parseFloat(line_price).toFixed(2);
                var new_line_total = parseFloat(new_price) * parseFloat(line_qty);
                
                $(this).closest('tr').find(".line_cost").val(parseFloat(new_price).toFixed(2));
                $(this).closest('tr').find(".line_price").val(parseFloat(new_price).toFixed(2));
                $(this).closest('tr').find(".line_total").val(parseFloat(new_line_total).toFixed(2));
           });
        }
   // $(".table-quotation tbody tr").each(function() {
   //      var line_price =  $(this).closest('tr').find(".line-price-origin").val();
   //      var line_qty =  $(this).closest('tr').find(".line_qty").val();
   //      //alert(line_price);
   //      var cur_rate = $(".rate").val();
   //      var new_price = parseFloat(line_price) * parseFloat(cur_rate);
   //      var new_line_total = parseFloat(new_price) * parseFloat(line_qty);
   //      $(this).closest('tr').find(".line_price").val(parseFloat(new_price).toFixed(2));
   //      $(this).closest('tr').find(".line_total").val(parseFloat(new_line_total).toFixed(2));
   //      cal_all();
   //  });
 }
 
 function editpay(e) {
     var pay_id = e.attr("data-id");
     var t_date = e.closest("tr").find(".trans-date").val();
     var t_time = e.closest("tr").find(".trans-time").val();
     var t_amount = e.closest("tr").find(".trans-amount").val();
     var t_note = e.closest("tr").find(".trans-note").val();
    // alert(pay_id);
     if(pay_id > 0){
          $(".recid").val(pay_id);
          $("#trans-date").val(t_date);
          $("#trans-time").val(t_time);
          $("#trans-amount").val(t_amount);
          $("#trans-note").val(t_note);
          $("#paymentModal").modal("show");
     }
 }
 function deletepay(e) {
   if(confirm("ต้องการลบรายการนี้ใช่หรือไม่?")){
       var pay_id = e.attr("data-id");
       if(pay_id > 0){
          $(".recid-delete").val(pay_id);
          $("#form-payment-delete").submit();
       }
   }
 }
 
 function checkamount(e){
        var payamount = e.val();
       
        if(payamount > 0){
           var amt = $(".total-amount").val();
           var total_payment = amt.replace(",","");
           //alert(total_payment);
           if(payment > parseFloat(total_payment)){
              alert("จำนวนที่ชำระมากกว่ายอดที่ต้องชำระ");
              e.val(0);
              return false;
           }
        }
 }
 
 
JS;
$this->registerJs($js, static::POS_END);
?>
