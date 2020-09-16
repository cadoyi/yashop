<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%sales_order}}`.
 */
class m200905_031020_create_sales_order_table extends Migration
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
            'id'                => $this->bigPk(),
            'increment_id'      => $this->bigFk()->unique()->comment('订单号'),
            'paid_increment_id' => $this->bigFk()->comment('支付订单号'),
            'paid_order_id'     => $this->bigFk()->comment('支付订单 ID'),
            'status'            => $this->string(32)->notNull()->comment('订单状态'),
            'customer_id'       => $this->fk()->comment('客户 ID'),
            'customer_nickname' => $this->string(32)->comment('客户昵称'),
            'customer_phone'    => $this->string()->comment('客户手机号'),
            'customer_email'    => $this->string()->comment('客户邮件'),
            'customer_avatar'   => $this->string()->comment('客户头像'),
            'customer_group_id' => $this->fk()->comment('客户组 ID'),
            'grand_total'       => $this->money()->comment('总价格'),
            'qty_ordered'       => $this->fk()->comment('总数量'),
            'is_virtual'        => $this->boolean()->notNull()->comment('是否虚拟单'),
            'store_id'          => $this->fk()->comment('店铺 ID'),
            'created_at'        => $this->inttime(),
            'updated_at'        => $this->inttime(),
        ], $this->tableOptions);

        $this->createIdx($this->table, 'paid_order_id');
        $this->createIdx($this->table, 'paid_increment_id');
        $this->createIdx($this->table, 'status');
        $this->createIdx($this->table, 'store_id');
        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropIdx($this->table, 'paid_order_id');
        $this->dropIdx($this->table, 'paid_increment_id');
        $this->dropIdx($this->table, 'status');
        $this->dropIdx($this->table, 'store_id');
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
