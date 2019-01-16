<?php

use yii\db\Migration;

/**
 * Class m180516_054350_add_column_to_journal_trans_table
 */
class m180516_054350_add_column_to_journal_trans_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('journal_trans','onhand_qty',$this->integer());
        $this->addColumn('journal_trans','counted_qty',$this->integer());
        $this->addColumn('journal_trans','diff_qty',$this->integer());
        $this->addColumn('journal_trans','from_wh',$this->integer());
        $this->addColumn('journal_trans','to_wh',$this->integer());
        $this->addColumn('journal_trans','from_loc',$this->integer());
        $this->addColumn('journal_trans','to_loc',$this->integer());
        $this->addColumn('journal_trans','from_lot',$this->integer());
        $this->addColumn('journal_trans','to_lot',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('journal_trans','onhand_qty');
        $this->dropColumn('journal_trans','counted_qty');
        $this->dropColumn('journal_trans','diff_qty');
        $this->dropColumn('journal_trans','from_wh');
        $this->dropColumn('journal_trans','to_wh');
        $this->dropColumn('journal_trans','from_loc');
        $this->dropColumn('journal_trans','to_loc');
        $this->dropColumn('journal_trans','from_lot');
        $this->dropColumn('journal_trans','to_lot');
 
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180516_054350_add_column_to_journal_trans_table cannot be reverted.\n";

        return false;
    }
    */
}
