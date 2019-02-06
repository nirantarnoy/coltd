<?php

use yii\db\Migration;

/**
 * Handles adding doc_no to table `{{%stock_balance}}`.
 */
class m190206_083750_add_doc_no_column_to_stock_balance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%stock_balance}}', 'doc_no', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%stock_balance}}', 'doc_no');
    }
}
