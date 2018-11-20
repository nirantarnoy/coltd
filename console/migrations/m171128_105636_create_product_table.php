<?php

use yii\db\Migration;

/**
 * Handles the creation of table `asset`.
 */
class m171128_105636_create_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'product_code' => $this->string(),
            'name' => $this->string(),
            'description' => $this->string(),
            'barcode' => $this->string(),
            'photo' => $this->string(),
            'category_id'=>$this->integer(),
            'product_type_id'=>$this->integer(),
            'unit_id'=>$this->integer(),
            'min_stock' => $this->float(),
            'max_stock' => $this->float(),
            'is_hold' => $this->integer(),
            'has_variant' => $this->integer(),
            'bom_type' => $this->integer(),
            'cost' => $this->float(),
            'price' => $this->float(),
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
        $this->dropTable('product');
    }
}
