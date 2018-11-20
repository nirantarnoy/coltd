<?php

use yii\db\Migration;

/**
 * Handles the creation of table `journal`.
 */
class m171128_121327_create_journal_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('journal', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'description' => $this->string(),
            'reference' => $this->string(),
            'reference_type_id' => $this->integer(),
            'trans_type' => $this->integer(),
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
        $this->dropTable('journal');
    }
}
