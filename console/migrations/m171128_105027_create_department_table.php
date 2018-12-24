<?php

use yii\db\Migration;

/**
 * Handles the creation of table `department`.
 */
class m171128_105027_create_department_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('department', [
            'id' => $this->primaryKey(),
            'company_id'=>$this->integer(),
            'name' => $this->string(),
            'description' => $this->string(),
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
        $this->dropTable('department');
    }
}
