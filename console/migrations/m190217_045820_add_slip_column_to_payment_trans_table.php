<?php

use yii\db\Migration;

/**
 * Handles adding slip to table `{{%payment_trans}}`.
 */
class m190217_045820_add_slip_column_to_payment_trans_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%payment_trans}}', 'slip', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%payment_trans}}', 'slip');
    }
}
