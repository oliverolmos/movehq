<?php

use yii\db\Migration;

class m200311_160506_initial_structure extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'email' => $this->string()->notNull()->unique(),
			'admin' => $this->boolean()->notNull(),
			'status' => $this->boolean()->defaultValue(1)->notNull(),
            'password_hash' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull()->unique(),
            'password_reset_token' => $this->string()->unique(),
            
        ], $tableOptions);

		$this->createTable('{{%contact}}', [
			'id' => $this->primaryKey(),
			'name' => $this->string(),
			'email' => $this->string()->unique(),
			'phone' => $this->string(10)->unique(),
			'address' => $this->string(),
			'subscribed' => $this->boolean()->defaultValue(1)->notNull(),
			'deleted' => $this->boolean()->defaultValue(0)->notNull(),
		], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%contact}}');
    }
}
