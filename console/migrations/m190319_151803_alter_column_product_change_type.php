<?php

use yii\db\Migration;

/**
 * Class m190319_151803_alter_column_product_change_type
 */
class m190319_151803_alter_column_product_change_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->alterColumn('product','unit_factor',$this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('product','unit_factor',$this->int());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190319_151803_alter_column_product_change_type cannot be reverted.\n";

        return false;
    }
    */
}
