<?php

use yii\db\Migration;

/**
 * Handles adding customer_country to table `{{%customer}}`.
 */
class m190224_054242_add_customer_country_column_to_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customer}}', 'customer_country', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%customer}}', 'customer_country');
    }
}
