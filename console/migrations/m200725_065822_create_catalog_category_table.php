<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%catalog_category}}`.
 */
class m200725_065822_create_catalog_category_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%catalog_category}}';

    public $fk = 'FK_CATALOG_CATEGORY_PARENT_ID_ID';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'         => $this->primaryKey(),
            'parent_id'  => $this->fk(false)->defaultValue(null),
            'path'       => $this->string()->defaultValue(null),
            'level'      => $this->integer()->notNull()->defaultValue(1),
            'title'      => $this->string(64)->notNull()->comment('分类标题'),
            'sort_order' => $this-> integer()->notNull()->defaultValue(1),
            'created_at' => $this->inttime(),
            'updated_at' => $this->inttime(),
        ], $this->tableOptions);

        $this->createIndex('IDX_CATALOG_CATEGORY_TITLE', $this->table, 'title');
        $this->createIndex('IDX_CATALOG_CATEGORY_PATH_LEVEL', $this->table, ['path', 'level']);
        $this->createIndex('IDX_CATALOG_CATEGORY_SORT_ORDER', $this->table, 'sort_order');
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
        $this->dropIndex('IDX_CATALOG_CATEGORY_TITLE', $this->table);
        $this->dropIndex('IDX_CATALOG_CATEGORY_PATH_LEVEL', $this->table);
        $this->dropIndex('IDX_CATALOG_CATEGORY_SORT_ORDER', $this->table);
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }


}
