<?php

use yii\db\Migration;

/**
 * Class m190110_075331_add_column_to_customer_table
 */
class m190110_075331_add_column_to_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('customer', 'first_name', $this->string());
        $this->addColumn('customer', 'last_name', $this->string());
        $this->addColumn('customer', 'card_id', $this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('customer', 'first_name');
        $this->dropColumn('customer', 'last_name');
        $this->dropColumn('customer', 'card_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190110_075331_add_column_to_customer_table cannot be reverted.\n";

        return false;
    }
    */
}
