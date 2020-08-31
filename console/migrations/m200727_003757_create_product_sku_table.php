<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%product_sku}}`.
 */
class m200727_003757_create_product_sku_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%product_sku}}';

    public $productTable = '{{%product}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'            => $this->bigPrimaryKey(),
            'product_id'    => $this->fk()->comment('产品 ID'),
            'sku'           => $this->string()->notNull()->unique()->comment('sku'),
            'price'         => $this->money()->notNull()->comment('价格'),
            'image'         => $this->string()->notNull()->comment('图片'),
            'qty'           => $this->integer()->unique()->unsigned()->comment('数量'),
            'promote_price' => $this->money()->comment('特殊价格'),
            'attrs'         => $this->text()->notNull()->comment('属性数据'), 
            'created_at'    => $this->inttime(),
            'updated_at'    => $this->inttime(),
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
