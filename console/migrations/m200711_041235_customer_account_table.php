<?php

use cando\db\Migration;

/**
 * Class m200711_041235_customer_account_table
 */
class m200711_041235_customer_account_table extends Migration
{



    /**
     * @type string 表名称
     */
    public $table = '{{%customer_account}}';

    public $customerTable = '{{%customer}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'          => $this->primaryKey(),
            'customer_id' => $this->fk(),
            'type'        => $this->string()->notNull()->comment('账户类型'),
            'username'    => $this->varchar()->notNull()->comment('账户名'),
            'password_hash' => $this->varchar()->notNull()->comment('账户密码'),
            'created_at'  => $this->inttime(),
            'updated_at'  => $this->inttime(),
        ], $this->tableOptions);

        $this->addFk($this->table, 'customer_id', $this->customerTable, 'id');;
        $this->createIndex(
            'UNQ_CUSTOMER_ACCOUNT_TYPE_USERNAME', 
            $this->table, 
            ['type', 'username'],
            true
        );
        $this->setForeignKeyChecks(true);
    }



    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropFk($this->table, 'customer_id', $this->customerTable, 'id');
        $this->dropIndex('UNQ_CUSTOMER_ACCOUNT_TYPE_USERNAME', $this->table);
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }

}
