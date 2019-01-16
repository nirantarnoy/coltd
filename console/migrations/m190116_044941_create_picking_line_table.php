<?php

use yii\db\Migration;

/**
 * Handles the creation of table `picking_line`.
 */
class m190116_044941_create_picking_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('picking_line', [
            'id' => $this->primaryKey(),
            'picking_id'=>$this->integer(),
            'product_id'=>$this->integer(),
            'qty'=>$this->float(),
            'site_id' =>$this->integer(),
            'warehouse_id' =>$this->integer(),
            'location_id' =>$this->integer(),
            'lot_id' => $this->integer(),
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
        $this->dropTable('picking_line');
    }
}
