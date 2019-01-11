<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quotation_line`.
 */
class m190110_071817_create_quotation_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('quotation_line', [
            'id' => $this->primaryKey(),
            'quotation_id' => $this->integer(),
            'product_id' => $this->integer(),
            'noneitem_name'=> $this->string(),
            'qty'=> $this->float(),
            'price'=> $this->float(),
            'disc_amount'=> $this->float(),
            'disc_percent'=> $this->float(),
            'line_amount' => $this->float(),
            'vat'=>$this->float(),
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
        $this->dropTable('quotation_line');
    }
}
