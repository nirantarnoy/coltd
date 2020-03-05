<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%export_file}}`.
 */
class m200305_070758_create_export_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%export_file}}', [
            'id' => $this->primaryKey(),
            'sale_id' => $this->integer(),
            'filename' => $this->string(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%export_file}}');
    }
}
