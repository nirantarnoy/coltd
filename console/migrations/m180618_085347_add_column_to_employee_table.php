<?php

use yii\db\Migration;

/**
 * Class m180618_085347_add_column_to_employee_table
 */
class m180618_085347_add_column_to_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('employee','salary_type',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('employee','salary_type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180618_085347_add_column_to_employee_table cannot be reverted.\n";

        return false;
    }
    */
}
