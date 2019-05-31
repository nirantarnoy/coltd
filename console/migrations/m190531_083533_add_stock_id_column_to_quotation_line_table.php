<?php

use yii\db\Migration;

/**
 * Handles adding stock_id to table `{{%quotation_line}}`.
 */
class m190531_083533_add_stock_id_column_to_quotation_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%quotation_line}}', 'stock_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%quotation_line}}', 'stock_id');
    }
}
