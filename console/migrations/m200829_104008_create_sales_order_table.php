<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%sales_order}}`.
 */
class m200829_104008_create_sales_order_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%sales_order}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'                => $this->bigInteger()->unsigned()->notNull()->comment('订单 ID'),
            'status'            => $this->string(32)->comment('订单状态'),
            'store_id'          => $this->fk()->comment('Store ID'),
            'customer_id'       => $this->fk()->comment('Customer ID'),
            'customer_group_id' => $this->fk()->comment('Customer group ID'),
            'increment_id'      => $this->bigInteger()->unsigned()->notNull()->unique()->comment('订单号'),
            'amount_increment_id' => $this->bigInteger()->unsigned()->notNull()->comment('付款订单号'),
            'grand_total'       => $this->money()->notNull()->comment('订单总额'),
            'qty_ordered'       => $this->integer()->unsigned()->notNull()->comment('购买数量'),
            'reviewed'          => $this->boolean()->notNull()->defaultValue(0)->comment('是否全部已评价'),
            'created_at'        => $this->inttime(),
            'updated_at'        => $this->inttime(),
        ], $this->tableOptions);

        $this->addPrimarykey('PK_SALES_ORDER_ID', $this->table, 'id');
        $this->createIndex('IDX_SALES_ORDER_STATUS', $this->table, 'status');
        $this->createIndex('IDX_SALES_ORDER_AMOUNT_INCREMENT_ID', $this->table, 'amount_increment_id');
        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropIndex('IDX_SALES_ORDER_AMOUNT_INCREMENT_ID', $this->table);
        $this->dropIndex('IDX_SALES_ORDER_STATUS', $this->table);
        $this->dropPrimaryKey('PK_SALES_ORDER_ID', $this->table);
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
