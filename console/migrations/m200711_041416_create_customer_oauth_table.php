<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%customer_oauth}}`.
 */
class m200711_041416_create_customer_oauth_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%customer_oauth}}';


    public $customerTable = '{{%customer}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'                  => $this->primaryKey(),
            'customer_id'         => $this->fk(),
            'type'                => $this->string()->notNull()->comment('oauth 账户类型'),
            'oauth_id'            => $this->string()->notNull()->comment('OAuth ID'),
            'data'                => $this->text()->comment('附加的数据'),
            'created_at'          => $this->inttime(),
            'updated_at'          => $this->inttime(),
        ], $this->tableOptions);

        $this->addFk($this->table, 'customer_id', $this->customerTable, 'id');
        $this->createIndex(
            'UNQ_CUSTOMER_OAUTH_TYPE_OAUTH_ID', 
            $this->table, 
            ['type', 'oauth_id'],
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
        $this->dropIndex('UNQ_CUSTOMER_OAUTH_TYPE_OAUTH_ID', $this->table);
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }


}
