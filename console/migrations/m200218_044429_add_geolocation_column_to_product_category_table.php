<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product_category}}`.
 */
class m200218_044429_add_geolocation_column_to_product_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_category}}', 'geolocation', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_category}}', 'geolocation');
    }
}
