<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%customer_address}}`.
 */
class m200711_091226_create_customer_address_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%customer_address}}';


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
            'tag'         => $this->varchar(32)->comment('地址标签'),
            'name'        => $this->varchar()->notNull()->comment('收货人'),
            'phone'       => $this->varchar(16)->notNull()->comment('手机或电话'),
            'region'      => $this->varchar(32)->notNull()->comment('省'),
            'city'        => $this->varchar(32)->notNull()->comment('市'),
            'area'        => $this->varchar(32)->comment('区'),
            'street'      => $this->text()->notNull()->comment('街道'),
            'zipcode'     => $this->varchar()->comment('邮政编码'),
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
