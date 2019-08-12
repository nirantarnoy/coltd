<?php

use yii\db\Migration;

/**
 * Handles adding price_carton_usd to table `{{%import_trans_line}}`.
 */
class m190812_134211_add_price_carton_usd_column_to_import_trans_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%import_trans_line}}', 'price_carton_usd', $this->float());
        $this->addColumn('{{%import_trans_line}}', 'price_carton_thb', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%import_trans_line}}', 'price_carton_usd');
        $this->dropColumn('{{%import_trans_line}}', 'price_carton_thb');
    }
}
