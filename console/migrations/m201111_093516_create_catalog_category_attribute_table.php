<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%catalog_category_attribute}}`.
 */
class m201111_093516_create_catalog_category_attribute_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%catalog_category_attribute}}';

    public $categoryTable = '{{%catalog_category}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'          => $this->primaryKey(),
            'category_id' => $this->fk()->comment('分类'),
            'name'        => $this->string()->notNull()->comment('属性名'),
            'input_type'  => $this->string()->notNull()->defaultValue('text')->comment('输入类型'),
            'json_items'  => $this->text()->defaultValue(null)->comment('json 选项'),
            'is_filterable' => $this->boolean()->notNull()->defaultValue(0)->comment('是否可搜索'),
            'is_deleted'  => $this->boolean()->notNull()->defaultValue(0)->comment('是否删除'),
            'created_at'  => $this->inttime(),
            'updated_at'  => $this->inttime(),
        ], $this->tableOptions);

        $this->addFk($this->table, 'category_id', $this->categoryTable, 'id');

        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropFk($this->table, 'category_id', $this->categoryTable, 'id');
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
