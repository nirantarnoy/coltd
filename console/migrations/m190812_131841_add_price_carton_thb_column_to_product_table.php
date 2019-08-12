<?php

use yii\db\Migration;

/**
 * Handles adding price_carton_thb to table `{{%product}}`.
 */
class m190812_131841_add_price_carton_thb_column_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'price_carton_thb', $this->float());
        $this->addColumn('{{%product}}', 'price_carton_usd', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'price_carton_thb');
        $this->dropColumn('{{%product}}', 'price_carton_usd');
    }
}
