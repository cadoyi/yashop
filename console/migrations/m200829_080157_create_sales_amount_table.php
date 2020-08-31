<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%sales_amount}}`.
 */
class m200829_080157_create_sales_amount_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%sales_amount}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'                => $this->bigInteger()->unsigned()->notNull()->comment('订单 ID'),
            'increment_id'            => $this->bigInteger()->unsigned()->notNull()->unique()->comment('订单编号'),
            'grand_total'       => $this->money()->notNull()->comment('订单总价'),
            'qty_ordered'       => $this->integer()->notNull()->comment('购买数量'),
            'customer_id'       => $this->fk()->comment('客户 ID'),
            'customer_group_id' => $this->fk()->comment('客户组 ID'),
            'quote_id'          => $this->string()->notNull()->comment('Quote id'),
            'remote_ip'         => $this->string(15)->notNull()->comment('远程 IP 地址'),
            'payment_method'    => $this->string()->comment('支付方法'),
            'payment_data'      => $this->text()->comment('支付数据'),
            'created_at'        => $this->inttime(),
            'updated_at'        => $this->inttime(),
        ], $this->tableOptions);

        $this->addPrimaryKey('PK_SALES_AMOUNT_ID', $this->table, 'id');
        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropPrimaryKey('PK_SALES_AMOUNT_ID', $this->table);
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
