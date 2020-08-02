<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%catalog_brand}}`.
 */
class m200725_065318_create_catalog_brand_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%catalog_brand}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'          => $this->primaryKey(),
            'name'        => $this->varchar()->notNull()->unique()->comment('品牌名'),
            'description' => $this->text()->comment('品牌描述'),
            'logo'        => $this->varchar()->comment('品牌 LOGO'),
            'sort_order'  => $this->integer()->notNull()->defaultValue(100)->comment('排序'),
            'created_at'  => $this->inttime(),
            'updated_at'  => $this->inttime(),
        ], $this->tableOptions);

        $this->createIndex('IDX_CATALOG_BRAND_SORT_ORDER', $this->table, 'sort_order');
        $this->setForeignKeyChecks(true);
    }




    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropIndex('IDX_BRAND_SORT_ORDER', $this->table);
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }


}
