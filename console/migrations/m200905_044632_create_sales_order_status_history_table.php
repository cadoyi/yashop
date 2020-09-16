<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%sales_order_status_history}}`.
 */
class m200905_044632_create_sales_order_status_history_table extends Migration
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
            'id'                => $this->bigPk(),
            'order_id'          => $this->bigFk()->comment('订单 ID'),
            'increment_id'      => $this->bigFk()->comment('订单号'),
            'paid_order_id'     => $this->bigFk()->comment('支付订单 ID'),
            'paid_increment_id' => $this->bigFk()->comment('支付订单号'),
            'status'            => $this->string()->notNull()->comment('订单状态'),
            'comment'           => $this->string()->comment('状态注释'),
            'created_at'        => $this->inttime(),
            'updated_at'        => $this->inttime(),
        ], $this->tableOptions);

        $this->createIdx($this->table, 'order_id');
        $this->createIdx($this->table, 'increment_id');
        $this->createIdx($this->table, 'paid_order_id');
        $this->createIdx($this->table, 'paid_increment_id');
        $this->createIdx($this->table, 'status');

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
        $this->dropIdx($this->table, 'status');
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
