<?php

use yii\db\Migration;

/**
 * Handles adding address to table `{{%customer}}`.
 */
class m190208_022627_add_address_column_to_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customer}}', 'address', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%customer}}', 'address');
    }
}
