<?php

use cando\db\Migration;

/**
 * Class m201114_085932_modify_product_table
 */
class m201114_085932_modify_product_table extends Migration
{

    public $table = '{{%product}}';

    public $typeTable = '{{%catalog_type}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->begin();
        $this->dropColumn($this->table, 'deleted_at');
        $this->dropFk($this->table, 'type_id', $this->typeTable, 'id');
        $this->dropColumn($this->table, 'type_id');
        $this->end();
    }



    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "不能撤销产品表修改";
        return false;
    }

}
