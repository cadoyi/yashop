<?php

use cando\db\Migration;

/**
 * Class m201112_124616_drop_category_parent_id_fk
 */
class m201112_124616_drop_category_parent_id_fk extends Migration
{
    public $table = '{{%catalog_category}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->begin();
        $this->dropFk($this->table, 'parent_id', $this->table, 'id');
        $this->end();
    }



    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->begin();
        $this->addFk($this->table, 'parent_id', $this->table, 'id');
        $this->end();
    }

}
