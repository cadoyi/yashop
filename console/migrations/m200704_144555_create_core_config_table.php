<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%core_config}}`.
 */
class m200704_144555_create_core_config_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%core_config}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'         => $this->primaryKey()->unsigned(),
            'path'       => $this->string()->notNull()->unique()->comment('配置路径'),
            'value'      => $this->text()->comment('配置值'),
            'multiple'   => $this->boolean()->notNull()->defaultValue(0)->comment('是否为多个值'),
            'created_at' => $this->integer()->unsigned()->notNull()->comment('创建时间'),
            'updated_at' => $this->integer()->unsigned()->notNull()->comment('更新时间'),
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
