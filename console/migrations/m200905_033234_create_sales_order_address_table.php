<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%sales_order_address}}`.
 */
class m200905_033234_create_sales_order_address_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%sales_order_address}}';



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
            'customer_id'       => $this->fk()->comment('客户 ID'),
            'customer_group_id' => $this->fk()->comment('客户组 ID'),
            'name'              => $this->string()->notNull()->comment('收货人'),
            'phone'             => $this->string(16)->notNull()->comment('手机号'),
            'tag'               => $this->string()->comment('标签'),
            'region'            => $this->string()->notNull()->comment('省'),
            'city'              => $this->string()->notNull()->comment('市'),
            'area'              => $this->string()->comment('区'),
            'street'            => $this->text()->notNull()->comment('详细地址'),
            'zipcode'           => $this->string()->comment('邮编'),
            'created_at'        => $this->inttime(),
            'updated_at'        => $this->inttime(), 
        ], $this->tableOptions);

        $this->createIdx($this->table, 'order_id');
        $this->createIdx($this->table, 'increment_id');
        $this->createIdx($this->table, 'paid_order_id');
        $this->createIdx($this->table, 'paid_increment_id');
        $this->createIdx($this->table, 'customer_id');
        $this->createIdx($this->table, 'customer_group_id');
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
        $this->dropIdx($this->table, 'customer_id');
        $this->dropIdx($this->table, 'customer_group_id');
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
