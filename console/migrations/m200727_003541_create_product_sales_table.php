<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%product_sales}}`.
 */
class m200727_003541_create_product_sales_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%product_sales}}';

    public $productTable = '{{%product}}';

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'product_id' => $this->fk()->unique()->comment('产品 ID'),
            'virtual_sales' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('虚拟销量'),
            'sales'    => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('真实销量'),
        ], $this->tableOptions);

        $this->addFk($this->table, 'product_id', $this->productTable, 'id');

        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropFk($this->table, 'product_id', $this->productTable, 'id');
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
