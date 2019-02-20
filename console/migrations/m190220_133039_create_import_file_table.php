<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%import_file}}`.
 */
class m190220_133039_create_import_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%import_file}}', [
            'id' => $this->primaryKey(),
            'import_id' => $this->integer(),
            'filename' => $this->string(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%import_file}}');
    }
}
