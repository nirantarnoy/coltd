<?php

use yii\db\Migration;

/**
 * Handles adding transport_in_date to table `{{%import_trans_line}}`.
 */
class m190813_140148_add_transport_in_date_column_to_import_trans_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%import_trans_line}}', 'transport_in_date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%import_trans_line}}', 'transport_in_date');
    }
}
