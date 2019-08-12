<?php

use yii\db\Migration;

/**
 * Handles adding qty to table `{{%product_stock}}`.
 */
class m190812_150739_add_qty_column_to_product_stock_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_stock}}', 'qty', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_stock}}', 'qty');
    }
}
