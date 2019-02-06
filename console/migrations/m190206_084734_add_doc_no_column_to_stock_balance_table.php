<?php

use yii\db\Migration;

/**
 * Handles adding doc_no to table `{{%stock_balance}}`.
 */
class m190206_084734_add_doc_no_column_to_stock_balance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%stock_balance}}', 'permit_no', $this->string());
        $this->addColumn('{{%stock_balance}}', 'permit_date', $this->date());
        $this->addColumn('{{%stock_balance}}', 'transport_in_no', $this->string());
        $this->addColumn('{{%stock_balance}}', 'transport_in_date', $this->date());
        $this->addColumn('{{%stock_balance}}', 'excise_no', $this->string());
        $this->addColumn('{{%stock_balance}}', 'excise_date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%stock_balance}}', 'permit_no');
        $this->dropColumn('{{%stock_balance}}', 'permit_date');
        $this->dropColumn('{{%stock_balance}}', 'transport_in_no');
        $this->dropColumn('{{%stock_balance}}', 'transport_in_date');
        $this->dropColumn('{{%stock_balance}}', 'excise_no');
        $this->dropColumn('{{%stock_balance}}', 'excise_date');
    }
}
