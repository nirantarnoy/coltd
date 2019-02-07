<?php

use yii\db\Migration;

/**
 * Class m190207_144529_add_stock_type_to_journal_trans_table
 */
class m190207_144529_add_stock_type_to_journal_trans_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%journal_trans}}', 'stock_type', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('journal_trans','stock_type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190207_144529_add_stock_type_to_journal_trans_table cannot be reverted.\n";

        return false;
    }
    */
}
