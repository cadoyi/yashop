<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%sales_order_item}}`.
 */
class m200829_114034_create_sales_order_item_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%sales_order_item}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id' => $this->bigInteger()->unsigned()->notNull()->comment('Item id'),
            'increment_id' => $this->bigInteger()->unsigned()->notNull()->comment('订单 ID'),
            'amount_increment_id' => $this->bigInteger()->unsigned()->notNull()->comment('订单 ID'),
            'quote_item_id'    => $this->string()->comment('quote item id'),            
            'store_id'         => $this->fk()->comment('店铺 ID'),
            'product_id'       => $this->string()->notNull()->comment('产品 ID'),
            'product_spu'      => $this->string()->notNull()->comment('产品 SPU'),
            'product_sku'      => $this->string()->comment('产品选项 SKU'),
            'product_sku_info' => $this->text()->comment('产品 SKU 信息'),
            'product_name'     => $this->string()->notNull()->comment('产品名'),
            'product_price'    => $this->money()->notNull()->comment('产品价格'),
            'product_image'    => $this->string()->notNull()->comment('产品图'),
            'grand_total'      => $this->money()->notNull()->comment('总价格'),
            'qty_ordered'      => $this->integer()->unsigned()->notNull()->comment('购买数量'),
            'is_virtual'       => $this->boolean()->notNull()->defaultValue(0)->comment('是否虚拟产品'),
            'created_at'       => $this->inttime(),
            'updated_at'       => $this->inttime(),
        ], $this->tableOptions);

        $this->addPrimaryKey('PK_SALES_ORDER_ITEM_ID', $this->table, 'id');
        $this->createIndex('IDX_SALES_ORDER_ITEM_INCREMENT_ID', $this->table, 'increment_id');
        $this->createIndex('IDX_SALES_ORDER_ITEM_AMOUNT_INCREMENT_ID', $this->table, 'amount_increment_id');

        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropIndex('IDX_SALES_ORDER_ITEM_INCREMENT_ID', $this->table);
        $this->dropIndex('IDX_SALES_ORDER_ITEM_AMOUNT_INCREMENT_ID', $this->table);
        $this->dropPrimaryKey('PK_SALES_ORDER_ITEM_ID', $this->table);
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
    
}
