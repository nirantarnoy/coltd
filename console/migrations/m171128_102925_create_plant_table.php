<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company`.
 */
class m171128_102925_create_plant_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('plant', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'short_name' => $this->string(),
            'eng_name' => $this->string(),
            'description' => $this->string(),
            'tax_id' => $this->string(),
            'email' => $this->string(),
            'mobile' => $this->string(),
            'phone' => $this->string(),
            'website' => $this->string(),
            'facebook' => $this->string(),
            'line' => $this->string(),
            'logo' => $this->string(),
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
        $this->dropTable('plant');
    }
}
