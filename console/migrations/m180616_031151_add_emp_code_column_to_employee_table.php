<?php

use yii\db\Migration;

/**
 * Handles adding emp_code to table `employee`.
 */
class m180616_031151_add_emp_code_column_to_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('employee','emp_code',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('employee','emp_code');
    }
}
