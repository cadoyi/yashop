<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%sales_order_status_history}}`.
 */
class m200829_122215_create_sales_order_status_history_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%sales_order_status_history}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id' => $this->bigInteger()->unsigned()->notNull()->comment('ID'),
            'increment_id' => $this->bigFk()->comment('订单号'),
            'amount_increment_id' => $this->bigFk()->comment('amount 订单号'),
            'status'  => $this->string()->notNull()->comment('状态'),
            'comment' => $this->string()->notNull()->comment('状态注释'),
            'visible_on_frontend' => $this->boolean()->notNull()->defaultValue(1)->comment('前端是否可见'),
            'created_at' => $this->inttime(),
            'updated_at' => $this->inttime(),
        ], $this->tableOptions);

        $this->addPrimaryKey('PK_SALES_ORDER_STATUS_HISTORY_ID', $this->table, 'id');
        $this->createIndex('IDX_SALES_ORDER_STATUS_HISTORY_INCREMENT_ID', $this->table, 'increment_id');
        $this->createIndex('IDX_SALES_ORDER_STATUS_HISTORY_AMOUNT_INCREMENT_ID', $this->table, 'amount_increment_id');
        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropIndex('IDX_SALES_ORDER_STATUS_HISTORY_AMOUNT_INCREMENT_ID', $this->table);
        $this->dropIndex('IDX_SALES_ORDER_STATUS_HISTORY_INCREMENT_ID', $this->table);
        $this->dropPrimaryKey('PK_SALES_ORDER_STATUS_HISTORY_ID', $this->table);
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
