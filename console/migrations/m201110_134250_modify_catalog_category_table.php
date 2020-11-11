<?php

use cando\db\Migration;

/**
 * Class m201110_134250_modify_catalog_category_table
 */
class m201110_134250_modify_catalog_category_table extends Migration
{

    public $table = '{{%catalog_category}}';


    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->addColumn($this->table, 'is_deleted', $this->boolean()->notNull()->defaultValue(0));
        
        $this->dropIndex('IDX_CATALOG_CATEGORY_PATH_LEVEL', $this->table);
        $this->alterColumn($this->table, 'parent_id', $this->fk(false)->defaultValue(0));
        $this->dropColumn($this->table, 'path');
        $this->dropColumn($this->table, 'level');
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
