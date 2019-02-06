<?php

use yii\db\Migration;

/**
 * Handles adding doc_no to table `{{%picking_line}}`.
 */
class m190206_082345_add_doc_no_column_to_picking_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%picking_line}}', 'doc_no', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%picking_line}}', 'doc_no');
    }
}
