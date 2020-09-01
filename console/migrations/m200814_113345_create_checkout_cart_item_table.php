<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%checkout_cart_item}}`.
 */
class m200814_113345_create_checkout_cart_item_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%checkout_cart_item}}';

    public $cartTable = '{{%checkout_cart}}';

    public $productTable = '{{%product}}';

    public $productSkuTable = '{{%product_sku}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'          => $this->primaryKey(),
            'cart_id'     => $this->fk()->comment('购物车 ID'),
            'product_id'  => $this->fk()->comment('产品 ID'),
            'product_sku_id' => $this->bigFk(false)->comment('产品 SKU ID'),
            'qty'         => $this->integer()->unsigned()->notNull()->comment('购买数量'),
            'created_at'  => $this->inttime(),
            'updated_at'  => $this->inttime(),
        ], $this->tableOptions);

        $this->addFk($this->table, 'cart_id', $this->cartTable, 'id');
        $this->addFk($this->table, 'product_id', $this->productTable, 'id');
        $this->addFk($this->table, 'product_sku_id', $this->productSkuTable, 'id');
        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropFk($this->table, 'cart_id', $this->cartTable, 'id');
        $this->dropFk($this->table, 'product_id', $this->productTable, 'id');
        $this->dropFk($this->table, 'product_sku_id', $this->productSkuTable, 'id');
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
