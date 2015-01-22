<?php

use yii\db\Schema;
use yii\db\Migration;

class m150122_121421_params extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%adm_params}}', [
            'id' => Schema::TYPE_PK,
            'url' => Schema::TYPE_STRING . "(250)",
            'text' => Schema::TYPE_TEXT,
            'updated_at' => Schema::TYPE_TIMESTAMP . " NOT NULL",
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%adm_params}}');
    }
}
