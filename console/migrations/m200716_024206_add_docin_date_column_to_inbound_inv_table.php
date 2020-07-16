<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%inbound_inv}}`.
 */
class m200716_024206_add_docin_date_column_to_inbound_inv_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%inbound_inv}}', 'docin_date', $this->datetime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%inbound_inv}}', 'docin_date');
    }
}
