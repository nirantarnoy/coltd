<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%inbound_inv}}`.
 */
class m200402_034652_add_currency_rate_column_to_inbound_inv_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%inbound_inv}}', 'currency_rate', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%inbound_inv}}', 'currency_rate');
    }
}
