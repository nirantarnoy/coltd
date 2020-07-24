<?php
?>
<div class="row">
    <div class="col-lg-12">

        <form method="post" action="<?=\yii\helpers\Url::to(['dbrestore/restoredb'],true)?>" enctype="multipart/form-data" id="form-restore">
            <label for="">เลือกไฟล์ที่ต้องการกู้คืนข้อมูล</label>
            <input type="file" name="restore_file" value="" accept=".sql" class="form-control">
            <br>
            <input type="submit" class="btn btn-success" value="ตกลง">
        </form>

    </div>
</div>
