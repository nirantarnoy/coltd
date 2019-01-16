<?php

use yii\db\Migration;

/**
 * Handles adding engname to table `{{%product}}`.
 */
class m190116_092551_add_engname_column_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'volumn', $this->float());
        $this->addColumn('{{%product}}', 'volumn_content', $this->float());
        $this->addColumn('{{%product}}', 'unit_factor', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'volumn');
        $this->dropColumn('{{%product}}', 'volumn_content');
        $this->dropColumn('{{%product}}', 'unit_factor');
    }
}
