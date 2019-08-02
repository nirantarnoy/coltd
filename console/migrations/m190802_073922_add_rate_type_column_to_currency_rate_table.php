<?php

use yii\db\Migration;

/**
 * Handles adding rate_type to table `{{%currency_rate}}`.
 */
class m190802_073922_add_rate_type_column_to_currency_rate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%currency_rate}}', 'rate_type', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%currency_rate}}', 'rate_type');
    }
}
