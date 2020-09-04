<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%checkout_quote_item}}`.
 */
class m200903_081353_create_checkout_quote_item_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%checkout_quote_item}}';

    public $quoteTable = '{{%checkout_quote}}';

    public $productTable = '{{%product}}';

    public $productSkuTable = '{{%product_sku}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'             => $this->bigPrimaryKey()->unsigned(),
            'quote_id'       => $this->fk()->comment('Quote ID'),
            'product_id'     => $this->fk()->comment('Product ID'),
            'product_sku_id' => $this->bigFk(false)->comment('产品 SKU ID'),
            'qty'            => $this->integer()->unsigned()->notNull()->comment('产品数量'),
            'created_at'     => $this->inttime(),
            'updated_at'     => $this->inttime(),
        ], $this->tableOptions);

        $this->addFk($this->table, 'quote_id', $this->quoteTable, 'id');
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
        $this->dropFk($this->table, 'quote_id', $this->quoteTable, 'id');
        $this->dropFk($this->table, 'product_id', $this->productTable, 'id');
        $this->dropFk($this->table, 'product_sku_id', $this->productSkuTable, 'id');
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
