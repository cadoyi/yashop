<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%checkout_cart}}`.
 */
class m200814_110138_create_checkout_cart_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%checkout_cart}}';

    public $customerTable = '{{%customer}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'          => $this->primaryKey(),
            'customer_id' => $this->fk()->unique()->comment('客户 ID'),
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
