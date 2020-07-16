<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%picking_line}}`.
 */
class m200716_013457_add_transport_out_line_num_column_to_picking_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%picking_line}}', 'transport_out_line_num', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%picking_line}}', 'transport_out_line_num');
    }
}
