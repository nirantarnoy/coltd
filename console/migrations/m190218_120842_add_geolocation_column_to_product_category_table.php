<?php

use yii\db\Migration;

/**
 * Handles adding geolocation to table `{{%product_category}}`.
 */
class m190218_120842_add_geolocation_column_to_product_category_table extends Migration
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
