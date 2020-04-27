<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%inbound_inv}}`.
 */
class m200427_092315_add_payment_status_column_to_inbound_inv_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%inbound_inv}}', 'payment_status', $this->integer());
        $this->addColumn('{{%inbound_inv}}', 'total_amount', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%inbound_inv}}', 'payment_status');
        $this->dropColumn('{{%inbound_inv}}', 'total_amount');
    }
}
