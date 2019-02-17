<?php

use yii\db\Migration;

/**
 * Handles adding excise_no to table `{{%product}}`.
 */
class m190215_145039_add_excise_no_column_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'excise_no', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'excise_no');
    }
}
