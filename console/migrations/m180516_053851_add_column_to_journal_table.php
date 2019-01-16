<?php

use yii\db\Migration;

/**
 * Class m180516_053851_add_column_to_journal_table
 */
class m180516_053851_add_column_to_journal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('journal','trans_date',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('journal','trans_date');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180516_053851_add_column_to_journal_table cannot be reverted.\n";

        return false;
    }
    */
}
