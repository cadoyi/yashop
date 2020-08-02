<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%catalog_template_attribute}}`.
 */
class m200726_130006_create_catalog_type_attribute_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%catalog_type_attribute}}';


    /**
     * @var string 类型表名
     */
    public $typeTable = '{{%catalog_type}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'         => $this->primaryKey(),
            'type_id'    => $this->fk()->comment('模板 ID'),
            'name'       => $this->string(64)->notNull()->comment('属性名'),
            'input_type' => $this->string(32)->notNull()->comment('输入类型'),
            'values'     => $this->text()->comment('可选值列表'),
            'is_active'  => $this->boolean()->notNull()->defaultValue(1),
            'created_at' => $this->inttime(),
            'updated_at' => $this->inttime(),
        ], $this->tableOptions);

        $this->addFk($this->table, 'type_id', $this->typeTable, 'id');
        $this->createIndex('UNQ_CATALOG_TYPE_ATTRIBUTE_TYPE_ID_NAME', $this->table, ['type_id', 'name'], true);
        $this->setForeignKeyChecks(true);
    }



    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropIndex('UNQ_CATALOG_TYPE_ATTRIBUTE_TYPE_ID_NAME', $this->table);
        $this->dropFk($this->table, 'type_id', $this->typeTable, 'id');
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }

    
}
