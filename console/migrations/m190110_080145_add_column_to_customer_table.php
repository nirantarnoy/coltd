<?php

use yii\db\Migration;

/**
 * Class m190110_080145_add_column_to_customer_table
 */
class m190110_080145_add_column_to_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('customer', 'email', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('customer', 'email');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190110_080145_add_column_to_customer_table cannot be reverted.\n";

        return false;
    }
    */
}
