<?php

use yii\db\Migration;

/**
 * Handles adding excise_date to table `{{%product}}`.
 */
class m190326_042826_add_excise_date_column_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'excise_date', $this->datetime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'excise_date');
    }
}
