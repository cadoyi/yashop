<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%menu_item}}`.
 */
class m200808_124222_create_front_menu_item_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%front_menu_item}}';

    public $menuTable = '{{%front_menu}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'         => $this->primaryKey(),
            'menu_id'    => $this->fk(),
            'parent_id'  => $this->fk(false)->defaultValue(null),
            'label'      => $this->string()->notNull()->comment('菜单名称'),
            'url'        => $this->text()->comment('菜单 url'),
            'sort_order' => $this->integer()->notNull()->defaultValue(100),
            'created_at' => $this->inttime(),
            'updated_at' => $this->inttime(),
        ], $this->tableOptions);

        $this->addFk($this->table, 'menu_id', $this->menuTable, 'id');
        $this->addFk($this->table, 'parent_id', $this->table, 'id');
        $this->setForeignKeyChecks(true);
    }



    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropFk($this->table, 'parent_id', $this->table, 'id');
        $this->dropFk($this->table, 'menu_id', $this->menuTable, 'id');
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
