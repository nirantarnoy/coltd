<?php

use yii\db\Migration;

/**
 * Class m190812_070219_add_inbound_id_column_to_import_trans
 */
class m190812_070219_add_inbound_id_column_to_import_trans extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190812_070219_add_inbound_id_column_to_import_trans cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190812_070219_add_inbound_id_column_to_import_trans cannot be reverted.\n";

        return false;
    }
    */
}
