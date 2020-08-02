<?php

use cando\db\Migration;

/**
 * Class m200726_124020_create_catalog_type_table
 */
class m200726_124020_create_catalog_type_table extends Migration
{

    public $table = '{{%catalog_type}}';


    public $categoryTable = '{{%catalog_category}}';


    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'          => $this->primaryKey(),
            'name'        => $this->varchar()->notNull()->unique()->comment('名称'),
            'category_id' => $this->fk()->comment('关联的分类'),
            'created_at'  => $this->inttime(),
            'updated_at'  => $this->inttime(),
        ], $this->tableOptions);

        $this->addFk($this->table, 'category_id', $this->categoryTable, 'id');

        $this->setForeignKeyChecks(true);
    }



    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropFk($this->table, 'category_id', $this->categoryTable, 'id');
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }



}
