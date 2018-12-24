<?php

use yii\db\Migration;

/**
 * Class m171130_141034_add_column_to_user_table
 */
class m171130_141034_add_column_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('user','group_id',$this->integer());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('user','group_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171130_141034_add_column_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
