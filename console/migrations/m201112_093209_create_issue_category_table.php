<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%issue_category}}`.
 */
class m201112_093209_create_issue_category_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%issue_category}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'code' => $this->string()->notNull()->unique()->comment('唯一码'),
            'title' => $this->string()->notNull()->comment('标题'),
            'is_deleted' => $this->boolean()->notNull()->defaultValue(0)->comment('是否删除'),
            'created_at' => $this->inttime(),
            'updated_at' => $this->inttime(),
        ], $this->tableOptions);
        $this->setForeignKeyChecks(true);
        parent::up();
    }


    public function safeUp()
    {
        $this->BatchInsert($this->table, ['code', 'title', 'created_at', 'updated_at'], [
            [
                'code' => 'customer',
                'title' => '客户帮助中心',
                'created_at' => time(),
                'updated_at' => time(),
            ],
            [
                'code'  => 'store',
                'title' => '店铺帮助中心',
                'created_at' => time(),
                'updated_at' => time(), 
            ],
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
