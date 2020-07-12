<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%customer}}`.
 */
class m200711_035839_create_customer_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%customer}}';


    /**
     * @var string 客户组表.
     */
    public $groupTable = '{{%customer_group}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'         => $this->primaryKey(),
            'nickname'   => $this->varchar(32)->comment('nickname'),
            'avatar'     => $this->varchar()->comment('avatar'),
            'auth_key'   => $this->string()->notNull()->comment('auth key'),
            'dob'        => $this->date()->comment('生日'),
            'gender'     => $this->boolean()->defaultValue(null)->comment('性别'),
            'qq'         => $this->string(16)->comment('QQ 号'),
            'login_at'   => $this->inttime(false),
            'is_active'  => $this->boolean()->notNull()->defaultValue(1)->comment('是否已启用'),
            'group_id'   => $this->fk()->comment('客户组'),
            'default_address' => $this->integer()->unsigned()->defaultValue(null)->comment('默认地址 ID'), 
            'created_at' => $this->inttime(),
            'updated_at' => $this->inttime(),
        ], $this->tableOptions);

        $this->addFk($this->table, 'group_id', $this->groupTable, 'id');
        $this->setForeignKeyChecks(true);
    }



    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropFk($this->table, 'group_id', $this->groupTable, 'id');
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }

    
}
