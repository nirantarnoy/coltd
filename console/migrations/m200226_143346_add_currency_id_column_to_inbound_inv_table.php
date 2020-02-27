<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%inboundinv}}`.
 */
class m200226_143346_add_currency_id_column_to_inbound_inv_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%inbound_inv}}', 'currency_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%inbound_inv}}', 'currency_id');
    }
}
