<?php

use yii\db\Migration;

/**
 * Handles adding qty to table `{{%product_cost}}`.
 */
class m190326_065609_add_qty_column_to_product_cost_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_cost}}', 'qty', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_cost}}', 'qty');
    }
}
