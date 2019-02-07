<?php

use yii\db\Migration;

/**
 * Handles adding origin to table `{{%product}}`.
 */
class m190207_132920_add_origin_column_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'origin', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'origin');
    }
}
