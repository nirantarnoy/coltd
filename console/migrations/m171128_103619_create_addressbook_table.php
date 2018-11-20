<?php

use yii\db\Migration;

/**
 * Handles the creation of table `addressbook`.
 */
class m171128_103619_create_addressbook_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('addressbook', [
            'id' => $this->primaryKey(),
            'address_type_id' => $this->integer(),
            'party_type_id' => $this->integer(),
            'party_id' => $this->integer(),
            'address' => $this->string(),
            'street' => $this->string(),
            'district_id' => $this->integer(),
            'city_id' => $this->integer(),
            'province_id' => $this->integer(),
            'zipcode' => $this->integer(),
            'is_primary' => $this->integer(),
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
        $this->dropTable('addressbook');
    }
}
