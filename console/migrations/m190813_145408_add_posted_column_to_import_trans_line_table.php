<?php

use yii\db\Migration;

/**
 * Handles adding posted to table `{{%import_trans_line}}`.
 */
class m190813_145408_add_posted_column_to_import_trans_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%import_trans_line}}', 'posted', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%import_trans_line}}', 'posted');
    }
}
