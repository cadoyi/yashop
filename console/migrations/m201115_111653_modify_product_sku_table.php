<?php

use cando\db\Migration;

/**
 * Class m201115_111653_modify_product_sku_table
 */
class m201115_111653_modify_product_sku_table extends Migration
{

    public $table = '{{%product_sku}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->begin();
        $this->dropColumn($this->table, 'promote_price');
        $this->end();
    }



    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->begin();
        $this->addColumn($this->table, 'promote_price', $this->money());
        $this->end();
    }

}
