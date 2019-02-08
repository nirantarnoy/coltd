<?php

use yii\db\Migration;

/**
 * Handles adding trans_date to table `{{%journal_line}}`.
 */
class m190208_134629_add_trans_date_column_to_journal_trans_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%journal_trans}}', 'trans_date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%journal_trans}}', 'trans_date');
    }
}
