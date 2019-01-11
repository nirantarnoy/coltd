<?php

use yii\db\Migration;

/**
 * Class m190111_094424_add_column_to_customer_table
 */
class m190111_094424_add_column_to_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('customer','customer_type',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('customer','customer_type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190111_094424_add_column_to_customer_table cannot be reverted.\n";

        return false;
    }
    */
}
