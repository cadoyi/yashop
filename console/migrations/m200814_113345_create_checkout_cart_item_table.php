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



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'          => $this->primaryKey(),
            'cart_id'     => $this->fk()->comment('购物车 ID'),
            'product_id'  => $this->string(32)->notNull()->comment('产品 ID'),
            'product_sku' => $this->string()->comment('产品 SKU 选项'),
            'qty'         => $this->integer()->unsigned()->notNull()->comment('购买数量'),
            'created_at'  => $this->inttime(),
            'updated_at'  => $this->inttime(),
        ], $this->tableOptions);

        $this->createIndex('IDX_CHECKOUT_CART_ITEM_PRODUCT_ID', $this->table, 'product_id');
        $this->addFk($this->table, 'cart_id', $this->cartTable, 'id');
        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropFk($this->table, 'cart_id', $this->cartTable, 'id');
        $this->dropIndex('IDX_CHECKOUT_CART_ITEM_PRODUCT_ID', $this->table);
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
