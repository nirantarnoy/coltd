<?php

use yii\db\Migration;

/**
 * Handles adding inv_no to table `{{%picking_line}}`.
 */
class m190527_131032_add_inv_no_column_to_picking_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('picking_line','inv_no',$this->string());
        $this->addColumn('picking_line','inv_date',$this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('picking_line','inv_no');
        $this->dropColumn('picking_line','inv_date');
    }
}
