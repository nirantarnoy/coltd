<?php

use yii\db\Migration;

/**
 * Handles adding invoice_date to table `{{%sale_invoice}}`.
 */
class m190207_113645_add_invoice_date_column_to_sale_invoice_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sale_invoice}}', 'invoice_date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sale_invoice}}', 'invoice_date');
    }
}
