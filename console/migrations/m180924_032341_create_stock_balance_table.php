<?php

use yii\db\Migration;

/**
 * Handles the creation of table `stock_balance`.
 */
class m180924_032341_create_stock_balance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('stock_balance', [
            'id' => $this->primaryKey(),
            'product_id'=>$this->integer(),
            'warehouse_id'=>$this->integer(),
            'loc_id'=>$this->integer(),
            'qty'=>$this->float(),
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
        $this->dropTable('stock_balance');
    }
}
