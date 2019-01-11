<?php

use yii\db\Migration;

/**
 * Handles the creation of table `customer`.
 */
class m171201_031001_create_customer_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('customer', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'description' => $this->string(),
            'customer_group_id' => $this->integer(),
            'payment_term' => $this->integer(),
            'payment_type' => $this->integer(),
            'delivery_type' => $this->integer(),
            'sale_id' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('customer');
    }
}
