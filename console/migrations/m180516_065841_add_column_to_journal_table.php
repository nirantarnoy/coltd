<?php

use yii\db\Migration;

/**
 * Class m180516_065841_add_column_to_journal_table
 */
class m180516_065841_add_column_to_journal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('journal','journal_no',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('journal','journal_no');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180516_065841_add_column_to_journal_table cannot be reverted.\n";

        return false;
    }
    */
}
