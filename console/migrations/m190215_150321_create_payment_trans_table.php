<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment_trans}}`.
 */
class m190215_150321_create_payment_trans_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payment_trans}}', [
            'id' => $this->primaryKey(),
            'trans_date' => $this->date(),
            'sale_id'=> $this->integer(),
            'amount'=> $this->float(),
            'payment_by' => $this->string(),
            'note'=> $this->string(),
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
        $this->dropTable('{{%payment_trans}}');
    }
}
