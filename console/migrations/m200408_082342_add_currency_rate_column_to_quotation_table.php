<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%quotation}}`.
 */
class m200408_082342_add_currency_rate_column_to_quotation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%quotation}}', 'currency_rate', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%quotation}}', 'currency_rate');
    }
}
