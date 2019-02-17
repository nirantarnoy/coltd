<?php

use yii\db\Migration;

/**
 * Handles adding permit_no to table `{{%plant}}`.
 */
class m190217_034100_add_permit_no_column_to_plant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%plant}}', 'permit_no', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%plant}}', 'permit_no');
    }
}
