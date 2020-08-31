<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%product_gallery}}`.
 */
class m200727_003727_create_product_gallery_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%product_gallery}}';

    public $productTable = '{{%product}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'product_id' => $this->fk()->comment('产品 ID'),
            'image' => $this->string()->notNull()->comment('产品图'),
            'sort_order' => $this->integer()->notNull()->defaultValue(1)->comment('排序'),
        ], $this->tableOptions);

        $this->addFk($this->table, 'product_id', $this->productTable, 'id');
        $this->createIndex('IDX_PRODUCT_GALLERY_SORT_ORDER', $this->table, 'sort_order');
        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropIndex('IDX_PRODUCT_GALLERY_SORT_ORDER', $this->table);
        $this->dropFk($this->table, 'product_id', $this->productTable, 'id');
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
