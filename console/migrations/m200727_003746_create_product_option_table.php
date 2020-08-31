<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%product_option}}`.
 */
class m200727_003746_create_product_option_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%product_option}}';

    public $productTable = '{{%product}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'         => $this->primaryKey(),
            'product_id' => $this->fk()->comment('产品 ID'),
            'name'       => $this->string()->notNull()->comment('选项名称'),
            'values'     => $this->text()->notNull()->comment('选项值列表'),
            'sort_order' => $this->integer()->notNull()->defaultValue(1)->comment('排序'),
        ], $this->tableOptions);

        $this->addFk($this->table, 'product_id', $this->productTable, 'id');
        $this->createIndex('UNQ_PRODUCT_OPTION_PRODUCT_ID_NAME', $this->table, ['product_id', 'name'], true);
        $this->createIndex('IDX_PRODUCT_OPTION_SORT_ORDER', $this->table, 'sort_order');
        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropFk($this->table, 'product_id', $this->productTable, 'id');
        $this->dropIndex('UNQ_PRODUCT_OPTION_PRODUCT_ID_NAME', $this->table);
        $this->dropIndex('IDX_PRODUCT_OPTION_SORT_ORDER', $this->table);
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
