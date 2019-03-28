<?php

use yii\widgets\ActiveForm;
$this->title = 'อัพโหลดไฟล์สำหรับกู้คืนข้อมูล';
?>
<div class="panel">
    <div class="panel-heading">
้      <h3><i class="fa fa-upload"></i> <?=$this->title;?></h3>
    </div>
    <div class="panel-body">
        <?php $form_upload = ActiveForm::begin(['action'=>'index.php?r=dbrestore/index','options'=>['enctype' => 'multipart/form-data']]); ?>

        <div class="row">
            <div class="col-lg-12">
                <br />

                <?= $form_upload->field($modelfile,'file')->fileinput(['class'=>'form-control','accept'=>'.sql'])->label(false)?>

            </div>
        </div>
        <br />

        <div class="modal-footer">
            <input type="submit" class="btn btn-success" value="ตกลง">
        </div>
        <?php ActiveForm::end();?>

    </div>
</div>
