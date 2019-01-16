<?php

use yii\db\Migration;

/**
 * Handles the creation of table `picking`.
 */
class m190116_062931_create_picking_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('picking', [
            'id' => $this->primaryKey(),
            'picking_no' => $this->string(),
            'trans_date' => $this->integer(),
            'sale_id' => $this->integer(),
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
        $this->dropTable('picking');
    }
}
