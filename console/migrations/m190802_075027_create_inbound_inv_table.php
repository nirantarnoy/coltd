<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%inbound_inv}}`.
 */
class m190802_075027_create_inbound_inv_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%inbound_inv}}', [
            'id' => $this->primaryKey(),
            'invoice_no' => $this->string(),
            'invoice_date' => $this->dateTime(),
            'delivery_term' => $this->integer(),
            'sold_to' => $this->string(),
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
        $this->dropTable('{{%inbound_inv}}');
    }
}
