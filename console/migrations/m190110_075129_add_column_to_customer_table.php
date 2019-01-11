<?php

use yii\db\Migration;

/**
 * Handles adding mobile to table `customer`.
 */
class m190110_075129_add_column_to_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('customer', 'code', $this->integer());
        $this->addColumn('customer', 'prefix', $this->integer());
        $this->addColumn('customer', 'mobile', $this->string());
        $this->addColumn('customer', 'line', $this->string());
        $this->addColumn('customer', 'facebook', $this->string());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('customer', 'code');
        $this->dropColumn('customer', 'prefix');
        $this->dropColumn('customer', 'mobile');
        $this->dropColumn('customer', 'line');
        $this->dropColumn('customer', 'facebook');
    }
}
