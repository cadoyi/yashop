<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%wishlist_product}}`.
 */
class m201117_133509_create_wishlist_product_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%wishlist_product}}';

    public $wishlistTable = '{{%wishlist}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'          => $this->primaryKey(),
            'wishlist_id' => $this->fk(),
            'product_id'  => $this->fk()->comment('产品 ID'),
            'created_at'  => $this->inttime(),
            'updated_at'  => $this->inttime(),
        ], $this->tableOptions);
        $this->addFk($this->table, 'wishlist_id', $this->wishlistTable, 'id');
        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropFk($this->table, 'wishlist_id', $this->wishlistTable, 'id');
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
