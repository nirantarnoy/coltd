<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product_stock}}`.
 */
class m200225_044458_add_outbound_id_column_to_product_stock_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_stock}}', 'outbound_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_stock}}', 'outbound_id');
    }
}
