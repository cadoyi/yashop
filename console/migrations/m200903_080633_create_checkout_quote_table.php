<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%checkout_quote}}`.
 */
class m200903_080633_create_checkout_quote_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%checkout_quote}}';

    public $customerTable = '{{%customer}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'          => $this->primaryKey(),
            'customer_id' => $this->fk()->unique()->comment('Customer ID'),
            'grand_total' => $this->money()->notNull()->defaultValue(0)->comment('总价'),
            'product_count' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('总产品数'),
            'qty'         => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('总库存数量'),
            'is_virtual'  => $this->boolean()->notNull()->comment('是否为虚拟产品'),
            'remote_ip'   => $this->string(15)->comment('远程 IP'),
            'created_at'  => $this->inttime(),
            'updated_at'  => $this->inttime(),
        ], $this->tableOptions);

        $this->addFk($this->table, 'customer_id', $this->customerTable, 'id');
        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropFk($this->table, 'customer_id', $this->customerTable, 'id');
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
