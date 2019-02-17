<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%import_trans_line}}`.
 */
class m190217_121444_create_import_trans_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%import_trans_line}}', [
            'id' => $this->primaryKey(),
            'import_id' => $this->integer(),
            'product_id'=> $this->integer(),
            'price_pack1' => $this->float(),
            'price_pack2' => $this->float(),
            'qty' => $this->integer(),
            'product_packing' => $this->integer(),
            'price_per' => $this->float(),
            'total_price' => $this->float(),
            'total_qty' => $this->integer(),
            'weight_litre' => $this->integer(),
            'netweight' => $this->float(),
            'grossweight' => $this->float(),
            'transport_in_no' => $this->string(),
            'line_num' => $this->integer(),
            'position' => $this->string(),
            'origin' => $this->string(),
            'excise_no' => $this->string(),
            'excise_date' => $this->date(),
            'kno' => $this->string(),
            'kno_date' => $this->date(),
            'permit_no' => $this->string(),
            'permit_date' => $this->date(),
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
        $this->dropTable('{{%import_trans_line}}');
    }
}
