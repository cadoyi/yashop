<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%front_menu}}`.
 */
class m200808_122714_create_front_menu_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%front_menu}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('菜单名称'),
            'code' => $this->string(32)->notNull()->unique()->comment('菜单代码'),
            'created_at' => $this->inttime(),
            'updated_at' => $this->inttime(),
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
