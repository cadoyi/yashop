<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%issue_menu}}`.
 */
class m201112_093954_create_issue_menu_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%issue_menu}}';

    public $categoryTable = '{{%issue_category}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'          => $this->primaryKey(),
            'category_id' => $this->fk()->comment('问题分类 ID'),
            'title'       => $this->string()->notNull()->comment('问题菜单标题'),
            'parent_id'   => $this->fk(false)->defaultValue(0)->comment('父菜单 ID'),
            'path'        => $this->string()->defaultValue(null),
            'level'       => $this->tinyInteger()->notNull()->defaultValue(1),
            'sort_order'  => $this->tinyInteger()->notNull()->defaultValue(1),
            'is_deleted'  => $this->boolean()->notNull()->defaultValue(0),
            'created_at'  => $this->inttime(),
            'updated_at'  => $this->inttime(),
        ], $this->tableOptions);

        $this->createIdx($this->table, ['category_id', 'path', 'level']);
        $this->createIdx($this->table, 'sort_order');
        $this->addFk($this->table, 'category_id', $this->categoryTable, 'id');
        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropIdx($this->table, 'sort_order');
        $this->dropIdx($this->table, ['category_id', 'path', 'level']);
        $this->dropFk($this->table, 'category_id', $this->categoryTable, 'id');
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
    
}
