<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%product_inventory}}`.
 */
class m200727_003609_create_product_inventory_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%product_inventory}}';

    public $productTable = '{{%product}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'          => $this->primaryKey(),
            'product_id'  => $this->fk()->unique()->comment('产品 ID'),
            'qty'         => $this->integer()->unsigned()->notNull()->comment('库存'),
            'qty_warning' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('库存预警值'),
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
