<?php

use yii\db\Migration;

/**
 * Handles adding unit_id to table `{{%sale_line}}`.
 */
class m190224_053144_add_unit_id_column_to_sale_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sale_line}}', 'unit_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sale_line}}', 'unit_id');
    }
}
