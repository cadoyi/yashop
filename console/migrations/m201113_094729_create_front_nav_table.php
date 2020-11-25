<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%front_nav}}`.
 */
class m201113_094729_create_front_nav_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%front_nav}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'parent_id' => $this->fk(false)->defaultValue(0),
            'title' => $this->string()->notNull()->comment('标题'),
            'path'  => $this->string()->defaultValue(null),
            'level' => $this->tinyInteger()->notNull()->defaultValue(0),
            'sort_order' => $this->tinyInteger()->notNull()->defaultValue(1),
            'is_deleted' => $this->boolean()->notNull()->defaultValue(0),
            'created_at' => $this->inttime(),
            'updated_at' => $this->inttime(),
        ], $this->tableOptions);

        $this->createIdx($this->table, 'sort_order');
        $this->createIdx($this->table, 'path');
        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropIdx($this->table, 'path');
        $this->dropIdx($this->table, 'sort_order');
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
