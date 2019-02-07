<?php

use yii\db\Migration;

/**
 * Handles adding geninv to table `{{%picking}}`.
 */
class m190207_055338_add_geninv_column_to_picking_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%picking}}', 'geninv', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%picking}}', 'geninv');
    }
}
