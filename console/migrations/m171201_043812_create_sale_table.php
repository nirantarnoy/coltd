<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sale`.
 */
class m171201_043812_create_sale_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('sale', [
            'id' => $this->primaryKey(),
            'sale_no'=> $this->string(),
            'revise'=> $this->integer(),
            'require_date' => $this->integer(),
            'customer_id' => $this->integer(),
            'customer_ref' => $this->string(),
            'delvery_to'=> $this->integer(),
            'currency'=> $this->integer(),
            'sale_id' => $this->integer(),
            'disc_amount' => $this->float(),
            'disc_percent' => $this->float(),
            'total_amount' => $this->float(),
            'quotation_id'=> $this->integer(),
            'note'=> $this->string(),
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
        $this->dropTable('sale');
    }
}
