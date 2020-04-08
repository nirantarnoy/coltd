<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%sale}}`.
 */
class m200408_082351_add_currency_rate_column_to_sale_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sale}}', 'currency_rate', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sale}}', 'currency_rate');
    }
}
