<?php

use cando\db\Migration;

/**
 * Handles the dropping of table `{{%wishlist_item}}`.
 */
class m201117_133405_drop_wishlist_item_table extends Migration
{

    public $table = '{{%wishlist_item}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }




    /**
     * {@inheritdoc}
     */
    public function down()
    {
        return false;
    }



}
