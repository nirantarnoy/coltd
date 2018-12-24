<?php

use yii\db\Migration;

/**
 * Handles adding user_id to table `employee`.
 */
class m180616_030841_add_user_id_column_to_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('employee','user_id',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('employee','user_id');
    }
}
