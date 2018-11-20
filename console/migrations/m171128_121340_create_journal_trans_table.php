<?php

use yii\db\Migration;

/**
 * Handles the creation of table `journal_trans`.
 */
class m171128_121340_create_journal_trans_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('journal_trans', [
            'id' => $this->primaryKey(),
            'journal_id' => $this->integer(),
            'product_id' => $this->integer(),
            'qty' => $this->float(),
            'journal_type_status' => $this->integer(),
            'line_amount'=> $this->float(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('journal_trans');
    }
}
