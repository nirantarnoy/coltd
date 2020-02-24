<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product_stock}}`.
 */
class m200224_073841_add_inbound_id_column_to_product_stock_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_stock}}', 'inbound_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_stock}}', 'inbound_id');
    }
}
