<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_stock}}`.
 */
class m190523_041225_create_product_stock_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_stock}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'warehouse_id' => $this->integer(),
            'in_qty' => $this->integer(),
            'out_qty' => $this->integer(),
            'invoice_no' => $this->string(),
            'invoice_date' => $this->datetime(),
            'transport_in_no' => $this->string(),
            'transport_in_date' => $this->datetime(),
            'sequence' => $this->integer(),
            'permit_no' => $this->string(),
            'permit_date' => $this->dateTime(),
            'kno_no_in' => $this->string(),
            'kno_in_date' => $this->dateTime(),
            'usd_rate' => $this->float(),
            'thb_amount' => $this->float(),
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
        $this->dropTable('{{%product_stock}}');
    }
}
