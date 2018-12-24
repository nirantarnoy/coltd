<?php

use yii\db\Migration;

/**
 * Handles the creation of table `employee`.
 */
class m171128_103822_create_employee_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('employee', [
            'id' => $this->primaryKey(),
            'gender_id' => $this->integer(),
            'prefix' => $this->integer(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'section_id' => $this->integer(),
            'position_id' => $this->integer(),
            'description' => $this->string(),
            'photo' => $this->string(),
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
        $this->dropTable('employee');
    }
}
