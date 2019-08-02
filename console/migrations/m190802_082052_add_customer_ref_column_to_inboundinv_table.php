<?php

use yii\db\Migration;

/**
 * Handles adding customer_ref to table `{{%inboundinv}}`.
 */
class m190802_082052_add_customer_ref_column_to_inboundinv_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%inbound_inv}}', 'customer_ref', $this->string());
        $this->addColumn('{{%inbound_inv}}', 'docin_no', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%inbound_inv}}', 'customer_ref');
        $this->dropColumn('{{%inbound_inv}}', 'docin_no');
    }
}
