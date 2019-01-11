<?php

use yii\db\Migration;

/**
 * Class m190111_094227_add_column_to_addressbook_table
 */
class m190111_094227_add_column_to_addressbook_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('addressbook','country_id',$this->string());
        $this->addColumn('addressbook','address_ext',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('addressbook','country_id');
        $this->dropColumn('addressbook','address_ext');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190111_094227_add_column_to_addressbook_table cannot be reverted.\n";

        return false;
    }
    */
}
