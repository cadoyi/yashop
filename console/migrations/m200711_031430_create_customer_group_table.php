<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%customer_group}}`.
 */
class m200711_031430_create_customer_group_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%customer_group}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(32)->notNull()->unique()->comment('客户组名'),
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
