<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%inbound_payment}}`.
 */
class m200427_090946_create_inbound_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%inbound_payment}}', [
            'id' => $this->primaryKey(),
            'trans_date' => $this->date(),
            'inbound_id'=> $this->integer(),
            'amount'=> $this->float(),
            'payment_by' => $this->string(),
            'note'=> $this->string(),
            'status' => $this->integer(),
            'slip' => $this->string(),
            'trans_time' => $this->time(),
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
        $this->dropTable('{{%inbound_payment}}');
    }
}
