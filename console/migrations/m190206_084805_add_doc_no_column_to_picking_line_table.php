<?php

use yii\db\Migration;

/**
 * Handles adding doc_no to table `{{%picking_line}}`.
 */
class m190206_084805_add_doc_no_column_to_picking_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%picking_line}}', 'permit_no', $this->string());
        $this->addColumn('{{%picking_line}}', 'permit_date', $this->date());
        $this->addColumn('{{%picking_line}}', 'transport_in_no', $this->string());
        $this->addColumn('{{%picking_line}}', 'transport_in_date', $this->date());
        $this->addColumn('{{%picking_line}}', 'excise_no', $this->string());
        $this->addColumn('{{%picking_line}}', 'excise_date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%picking_line}}', 'permit_no');
        $this->dropColumn('{{%picking_line}}', 'permit_date');
        $this->dropColumn('{{%picking_line}}', 'transport_in_no');
        $this->dropColumn('{{%picking_line}}', 'transport_in_date');
        $this->dropColumn('{{%picking_line}}', 'excise_no');
        $this->dropColumn('{{%picking_line}}', 'excise_date');
    }
}
