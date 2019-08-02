<?php

use yii\db\Migration;

/**
 * Handles adding payment_status to table `{{%sale}}`.
 */
class m190802_041937_add_payment_status_column_to_sale_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sale}}', 'payment_status', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sale}}', 'payment_status');
    }
}
