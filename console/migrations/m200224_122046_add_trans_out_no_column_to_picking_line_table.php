<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%picking_line}}`.
 */
class m200224_122046_add_trans_out_no_column_to_picking_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%picking_line}}', 'trans_out_no', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%picking_line}}', 'trans_out_no');
    }
}
