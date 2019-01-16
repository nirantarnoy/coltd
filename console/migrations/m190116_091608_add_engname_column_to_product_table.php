<?php

use yii\db\Migration;

/**
 * Handles adding engname to table `{{%product}}`.
 */
class m190116_091608_add_engname_column_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'engname', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'engname');
    }
}
