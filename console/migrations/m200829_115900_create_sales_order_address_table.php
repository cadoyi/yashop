<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%sales_order_address}}`.
 */
class m200829_115900_create_sales_order_address_table extends Migration
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
            'id' => $this->bigInteger()->unsigned()->notNull()->comment('ID'),
            'increment_id' => $this->bigFk()->comment('订单号'),
            'amount_increment_id' => $this->bigFk()->comment('amount订单号'),
            'customer_id' => $this->fk()->comment('customer id'),
            'region' => $this->string()->notNull()->comment('省'),
            'city'   => $this->string()->notNull()->comment('市'),
            'area'   => $this->string()->comment('区'),
            'street' => $this->text()->comment('街道地址'),
            'name'   => $this->string()->notNull()->comment('收货人'),
            'phone'  => $this->string(15)->notNull()->comment('电话'),
            'tag'    => $this->string()->comment('地址标签'),
            'created_at' => $this->inttime(),
            'updated_at' => $this->inttime(),
        ], $this->tableOptions);

        $this->addPrimaryKey('PK_SALES_ORDER_ADDRESS_ID', $this->table, 'id');
        $this->createIndex('IDX_SALES_ORDER_ADDRESS_INCREMENT_ID', $this->table, 'increment_id');
        $this->createIndex('IDX_SALES_ORDER_ADDRESS_AMOUNT_INCREMENT_ID', $this->table, 'amount_increment_id');
        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropIndex('IDX_SALES_ORDER_ADDRESS_AMOUNT_INCREMENT_ID', $this->table);
        $this->dropIndex('IDX_SALES_ORDER_ADDRESS_INCREMENT_ID', $this->table);
        $this->dropPrimaryKey('PK_SALES_ORDER_ADDRESS_ID', $this->table);
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
