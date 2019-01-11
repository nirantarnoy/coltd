<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sale_invoice`.
 */
class m190110_072111_create_sale_invoice_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sale_invoice', [
            'id' => $this->primaryKey(),
            'invoice_no'=> $this->string(),
            'sale_id' => $this->integer(),
            'disc_amount' => $this->float(),
            'disc_percent' => $this->float(),
            'total_amount' => $this->float(),
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
        $this->dropTable('sale_invoice');
    }
}
