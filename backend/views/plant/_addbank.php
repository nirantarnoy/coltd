<?php
use yii\helpers\ArrayHelper;
use backend\models\Bank;
use yii\helpers\Html;

?>

<tr id="shop-bank-id" style="vertical-align: middle;">
    <td style="vertical-align: middle;">
      <?= Html::img('@web/uploads/logo/'.Bank::getLogo($data["id"]),['style'=>'width: 20%;']);?>
      <input type="hidden" class="bank_id" name="bank_id[]" value="<?= $data["id"];?>"/>
    </td>
    <td style="vertical-align: middle;"><?= $data["bank_name"];?></td>
    
   <td style="vertical-align: middle;">
    <?= $data["account_no"];?>
    <input type="hidden" class="account_no" id="account_no" name="account_no[]" value="<?= $data["account_no"];?>"/>
  </td>
  <td style="vertical-align: middle;">
    <?= $data["account_name"];?>
    <input type="hidden" class="account_name" id="account_name" name="account_name[]" value="<?= $data["account_name"];?>"/>
  </td>
  <td style="vertical-align: middle;">
    <?= \backend\helpers\AccountType::getTypeById($data["account_type"]);?>
    <input type="hidden" class="account_no" id="account_no" name="account_no[]" value="<?= $data["account_no"];?>"/>
    <input type="hidden" class="account_type" id="account_type" name="account_type[]" value="<?= $data["account_type"];?>"/>
    <input type="hidden" class="description" name="description[]" value="<?= $data["description"];?>"/>
  </td>
    
  <td class="action">
      <a class="btn btn-white remove-line" onClick="bankedit($(this));" href="javascript:void(0);"><i class="fa fa-edit"></i></a>
      <a class="btn btn-white remove-line" onClick="bankRemove($(this));" href="javascript:void(0);"><i class="fa fa-trash-o"></i></a>
    </td>
</tr>
