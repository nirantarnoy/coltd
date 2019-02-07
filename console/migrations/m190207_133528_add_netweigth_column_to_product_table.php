<?php

use yii\db\Migration;

/**
 * Handles adding netweigth to table `{{%product}}`.
 */
class m190207_133528_add_netweigth_column_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'netweight', $this->float());
        $this->addColumn('{{%product}}', 'grossweight', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'netweight');
        $this->dropColumn('{{%product}}', 'grossweight');
    }
}
