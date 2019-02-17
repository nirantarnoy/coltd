<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%currency_rate}}`.
 */
class m190215_145604_create_currency_rate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%currency_rate}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'from_currency' => $this->integer(),
            'to_integer' => $this->integer(),
            'rate' => $this->float(),
            'rate_factor' => $this->float(),
            'from_date' => $this->date(),
            'to_date' => $this->date(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%currency_rate}}');
    }
}
