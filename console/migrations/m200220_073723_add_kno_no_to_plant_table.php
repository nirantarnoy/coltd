<?php

use yii\db\Migration;

/**
 * Class m200220_073723_add_kno_no_to_plant_table
 */
class m200220_073723_add_kno_no_to_plant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%plant}}', 'kno_no', $this->string());
        $this->addColumn('{{%plant}}', 'kno_date', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%plant}}', 'kno_no');
        $this->dropColumn('{{%plant}}', 'kno_date');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200220_073723_add_kno_no_to_plant_table cannot be reverted.\n";

        return false;
    }
    */
}
