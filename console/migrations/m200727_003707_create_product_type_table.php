<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%product_type}}`.
 */
class m200727_003707_create_product_type_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%product_type}}';

    public $productTable = '{{%product}}';

    public $typeTable = '{{%catalog_type}}';

    public $typeAttributeTable = '{{%catalog_type_attribute}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'                => $this->bigPrimaryKey(),
            'product_id'        => $this->fk()->comment('产品 ID'),
            'type_id'           => $this->fk()->comment('产品类型 ID'),
            'type_attribute_id' => $this->fk()->comment('产品类型属性 ID'),
            'value'             => $this->text()->comment('属性值'),
        ], $this->tableOptions);

        $this->addFk($this->table, 'product_id', $this->productTable, 'id');
        $this->addFk($this->table, 'type_id', $this->typeTable, 'id');
        $this->addFk($this->table, 'type_attribute_id', $this->typeAttributeTable, 'id');
        $this->createIndex('UNQ_PRODUCT_TYPE_PRODUCT_ID_TYPE_ID_TYPE_ATTRIBUTE_ID', $this->table, ['product_id', 'type_id', 'type_attribute_id'], true);
        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropIndex('UNQ_PRODUCT_TYPE_PRODUCT_ID_TYPE_ID_TYPE_ATTRIBUTE_ID', $this->table);
        $this->dropFk($this->table, 'product_id', $this->productTable, 'id');
        $this->dropFk($this->table, 'type_id', $this->typeTable, 'id');
        $this->dropFk($this->table, 'type_attribute_id', $this->typeAttributeTable, 'id');
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
