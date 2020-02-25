<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%picking_line}}`.
 */
class m200225_014917_add_kno_out_no_column_to_picking_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%picking_line}}', 'kno_out_no', $this->string());
        $this->addColumn('{{%picking_line}}', 'kno_out_date', $this->datetime());
        $this->addColumn('{{%picking_line}}', 'transport_out_no', $this->string());
        $this->addColumn('{{%picking_line}}', 'transport_out_date', $this->datetime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%picking_line}}', 'kno_out_no');
        $this->dropColumn('{{%picking_line}}', 'kno_out_date');
        $this->dropColumn('{{%picking_line}}', 'transport_out_no');
        $this->dropColumn('{{%picking_line}}', 'transport_out_date');
    }
}
