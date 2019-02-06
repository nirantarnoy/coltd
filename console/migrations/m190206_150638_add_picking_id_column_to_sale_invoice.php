<?php

use yii\db\Migration;

/**
 * Class m190206_150638_add_picking_id_column_to_sale_invoice
 */
class m190206_150638_add_picking_id_column_to_sale_invoice extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('sale_invoice','picking_id',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('sale_invoice','picking_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190206_150638_add_picking_id_column_to_sale_invoice cannot be reverted.\n";

        return false;
    }
    */
}
