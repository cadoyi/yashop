<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%sales_order_item}}`.
 */
class m200905_033215_create_sales_order_item_table extends Migration
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
            'id'                => $this->bigPk(),
            'order_id'          => $this->bigFk()->comment('订单 ID'),
            'paid_order_id'     => $this->bigFk()->comment('付款单 ID'),
            'increment_id'      => $this->bigFk()->comment('订单号'),
            'paid_increment_id' => $this->bigFk()->comment('付款单号'),
            'store_id'          => $this->fk()->comment('店铺 ID'),
            'product_id'        => $this->fk()->comment('产品 ID'),
            'name'              => $this->string()->notNull()->comment('产品名'),
            'spu'               => $this->string()->notNull()->comment('主产品 SKU'),
            'image'             => $this->string()->notNull()->comment('产品图'),
            'price'             => $this->money()->notNull()->comment('产品价格'),
            'is_selectable'     => $this->boolean()->notNull()->comment('可选商品'),
            'is_virtual'        => $this->boolean()->notNull()->comment('虚拟商品'),
            'product_sku_id'    => $this->fk(false)->comment('产品 SKU ID'),
            'product_sku_attrs' => $this->text()->comment('产品 SKU 属性'),
            'product_sku_sku'   => $this->string()->comment('产品 SKU 的 SKU'),
            'product_sku_price' => $this->money()->comment('产品 SKU 价格'),
            'product_sku_image' => $this->string()->comment('产品 SKU 图片'),
            'row_total'         => $this->money()->notNull()->comment('产品总价'),
            'qty_ordered'       => $this->fk()->comment('产品总数量'),
            'created_at'        => $this->inttime(),
            'updated_at'        => $this->inttime(),
        ], $this->tableOptions);

        $this->createIdx($this->table, 'order_id');
        $this->createIdx($this->table, 'increment_id');
        $this->createIdx($this->table, 'paid_order_id');
        $this->createIdx($this->table, 'paid_increment_id');
        $this->createIdx($this->table, 'product_id');
        $this->createIdx($this->table, 'product_sku_id');
        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropIdx($this->table, 'order_id');
        $this->dropIdx($this->table, 'increment_id');
        $this->dropIdx($this->table, 'paid_order_id');
        $this->dropIdx($this->table, 'paid_increment_id');
        $this->dropIdx($this->table, 'product_id');
        $this->dropIdx($this->table, 'product_sku_id');
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
