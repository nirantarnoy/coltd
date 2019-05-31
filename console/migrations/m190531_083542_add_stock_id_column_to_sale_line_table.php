<?php

use yii\db\Migration;

/**
 * Handles adding stock_id to table `{{%sale_line}}`.
 */
class m190531_083542_add_stock_id_column_to_sale_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sale_line}}', 'stock_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sale_line}}', 'stock_id');
    }
}
