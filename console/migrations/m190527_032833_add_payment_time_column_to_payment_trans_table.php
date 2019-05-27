<?php

use yii\db\Migration;

/**
 * Handles adding payment_time to table `{{%payment_trans}}`.
 */
class m190527_032833_add_payment_time_column_to_payment_trans_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%payment_trans}}', 'trans_time', $this->time());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%payment_trans}}', 'trans_time');
    }
}
