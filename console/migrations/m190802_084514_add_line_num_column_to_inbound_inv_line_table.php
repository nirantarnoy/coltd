<?php

use yii\db\Migration;

/**
 * Handles adding line_num to table `{{%inbound_inv_line}}`.
 */
class m190802_084514_add_line_num_column_to_inbound_inv_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%inbound_inv_line}}', 'line_num', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%inbound_inv_line}}', 'line_num');
    }
}
