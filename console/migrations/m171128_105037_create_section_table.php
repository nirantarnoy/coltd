<?php

use yii\db\Migration;

/**
 * Handles the creation of table `section`.
 */
class m171128_105037_create_section_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('section', [
            'id' => $this->primaryKey(),
            'department_id'=>$this->integer(),
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
        $this->dropTable('section');
    }
}
