<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%inbound_inv_line}}`.
 */
class m190802_075035_create_inbound_inv_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%inbound_inv_line}}', [
            'id' => $this->primaryKey(),
            'invoice_id' => $this->integer(),
            'product_id' => $this->integer(),
            'warehouse_id' => $this->integer(),
            'line_qty' => $this->integer(),
            'invoice_no' => $this->string(),
            'invoice_date' => $this->datetime(),
            'transport_in_no' => $this->string(),
            'transport_in_date' => $this->datetime(),
            'sequence' => $this->integer(),
            'permit_no' => $this->string(),
            'permit_date' => $this->dateTime(),
            'kno_no_in' => $this->string(),
            'kno_in_date' => $this->dateTime(),
            'line_price' => $this->float(),
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
        $this->dropTable('{{%inbound_inv_line}}');
    }
}
