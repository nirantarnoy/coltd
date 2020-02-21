<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%inbound_inv}}`.
 */
class m200221_061441_add_supplier_id_column_to_inbound_inv_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%inbound_inv}}', 'supplier_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%inbound_inv}}', 'supplier_id');
    }
}
