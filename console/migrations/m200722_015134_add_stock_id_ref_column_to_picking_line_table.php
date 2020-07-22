<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%picking_line}}`.
 */
class m200722_015134_add_stock_id_ref_column_to_picking_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%picking_line}}', 'stock_id_ref', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%picking_line}}', 'stock_id_ref');
    }
}
