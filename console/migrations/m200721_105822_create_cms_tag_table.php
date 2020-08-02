<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%cms_tag}}`.
 */
class m200721_105822_create_cms_tag_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%cms_tag}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->notNull()->unique()->comment('标签名'),
            'created_at' => $this->inttime(),
            'updated_at' => $this->inttime(),
        ], $this->tableOptions);
        $this->setForeignKeyChecks(true);
        return parent::up();
    }


    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->insert($this->table, [
            'id'         => 1,
            'name'       => 'default',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
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
