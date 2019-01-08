<?php

use yii\db\Migration;

/**
 * Class m180504_042906_add_column_to_product_table
 */
class m180504_042906_add_column_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product','all_qty',$this->float());
        $this->addColumn('product','available_qty',$this->float());
        $this->addColumn('product','reserved_qty',$this->float());
        $this->addColumn('product','shelf_life',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('product','all_qty');
        $this->dropColumn('product','available_qty');
        $this->dropColumn('product','reserved_qty');
        $this->dropColumn('product','shelf_life');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180504_042906_add_column_to_product_table cannot be reverted.\n";

        return false;
    }
    */
}
