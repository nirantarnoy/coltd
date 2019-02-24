<?php

use yii\db\Migration;

/**
 * Handles adding picking_date to table `{{%picking}}`.
 */
class m190224_060645_add_picking_date_column_to_picking_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%picking}}', 'picking_date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%picking}}', 'picking_date');
    }
}
