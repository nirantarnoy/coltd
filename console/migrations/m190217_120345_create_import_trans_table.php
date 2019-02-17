<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%import_trans}}`.
 */
class m190217_120345_create_import_trans_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%import_trans}}', [
            'id' => $this->primaryKey(),
            'invoice_no' => $this->string(),
            'invoice_date' => $this->date(),
            'vendor_id' => $this->integer(),
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
        $this->dropTable('{{%import_trans}}');
    }
}
