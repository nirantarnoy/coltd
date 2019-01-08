<?php
//use yii\jui\AutoComplete;
//use yii\web\JsExpression;

$data = \backend\models\Product::find()
    ->select(['name as value', 'name as  label','id as id'])
    ->asArray()
    ->all();
?>
<tr id="row-" style="vertical-align: middle">
    <td>#</td>
    <td>
        <input type="text" name="vendor_id[]" class="form-control vendor_id" value="">
    </td>
    <td>
        <input type="text" name="name[]" class="form-control name" value="">
    </td>
    <td>
        <input type="text" name="from_date[]" class="form-control from_date" value="">
    </td>
    <td>
        <input type="text" name="to_date[]" class="form-control to_date" value="">
    </td>
    <td>
        <div class="btn btn-danger" onclick="removeline($(this))"><i class="fa fa-minus"></i> ลบ</div>
    </td>
</tr>
