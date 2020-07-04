<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%admin_user}}`.
 */
class m200703_074130_create_admin_user_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%admin_user}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'            => $this->primaryKey(),
            'username'      => $this->varchar(32)->notNull()->unique()->comment('用户名'), 
            'nickname'      => $this->varchar(32)->notNull()->comment('昵称'),
            'auth_key'      => $this->char(32)->notNull()->comment('认证 key'),
            'password_hash' => $this->varchar(66)->notNull()->comment('密码'),
            'avatar'        => $this->varchar()->comment('头像'),
            'is_active'     => $this->boolean()->defaultValue(1)->notNull()->comment('是否已激活'),
            'last_login_at' => $this->inttime(false)->defaultValue(null)->comment('最后登录时间'),
            'last_login_ip' => $this->varchar()->comment('最后登录 IP'),
            'created_at'    => $this->inttime()->notNull(),
            'updated_at'    => $this->inttime()->notNull(),
        ], $this->tableOptions);
        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
