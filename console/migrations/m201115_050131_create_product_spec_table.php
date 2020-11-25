<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%product_spec}}`.
 */
class m201115_050131_create_product_spec_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%product_spec}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'           => $this->primaryKey(),
            'product_id'   => $this->fk()->comment('产品 ID'),
            'category_id'  => $this->fk()->comment('分类 ID'),
            'attribute_id' => $this->fk()->comment('属性 ID'),
            'value'        => $this->text()->comment('属性值'),
            'created_at'   => $this->inttime(),
            'updated_at'   => $this->inttime(),
        ], $this->tableOptions);

        $this->createIdx($this->table, ['product_id', 'attribute_id']);
        $this->createIdx($this->table, ['category_id', 'attribute_id']);
        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropIdx($this->table, ['product_id', 'attribute_id']);
        $this->dropIdx($this->table, ['category_id', 'attribute_id']);
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
