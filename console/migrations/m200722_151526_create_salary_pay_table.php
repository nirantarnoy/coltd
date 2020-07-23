<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%salary_pay}}`.
 */
class m200722_151526_create_salary_pay_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%salary_pay}}', [
            'id' => $this->primaryKey(),
            'pay_no' => $this->string(),
            'pay_period' => $this->integer(),
            'note' => $this->string(),
            'trans_date' => $this->datetime(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%salary_pay}}');
    }
}
