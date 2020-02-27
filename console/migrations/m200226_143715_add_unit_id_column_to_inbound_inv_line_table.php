<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%inbound_inv_line}}`.
 */
class m200226_143715_add_unit_id_column_to_inbound_inv_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%inbound_inv_line}}', 'unit_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%inbound_inv_line}}', 'unit_id');
    }
}
