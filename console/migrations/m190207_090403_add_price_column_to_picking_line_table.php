<?php

use yii\db\Migration;

/**
 * Handles adding price to table `{{%picking_line}}`.
 */
class m190207_090403_add_price_column_to_picking_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%picking_line}}', 'price', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%picking_line}}', 'price');
    }
}
