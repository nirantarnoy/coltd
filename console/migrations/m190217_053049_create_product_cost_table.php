<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_cost}}`.
 */
class m190217_053049_create_product_cost_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_cost}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'trans_date' => $this->integer(),
            'transport_in_no' => $this->string(),
            'transport_in_date' => $this->date(),
            'permit_no' => $this->string(),
            'permit_date' => $this->date(),
            'excise_no' => $this->string(),
            'excise_date' => $this->date(),
            'cost' => $this->float(),
            'note' => $this->string(),
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
        $this->dropTable('{{%product_cost}}');
    }
}
