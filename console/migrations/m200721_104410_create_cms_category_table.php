<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%cms_category}}`.
 */
class m200721_104410_create_cms_category_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%cms_category}}';
 
    /**
     * @var string name 索引名称.
     */
    public $nameIndex = 'IDX_CMS_CATEGORY_NAME';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'        => $this->primaryKey(),
            'name'      => $this->string()->notNull()->comment('分类名称'),
            'description' => $this->text()->comment('分类描述'),
            'created_at' => $this->inttime(),
            'updated_at' => $this->inttime(), 
        ], $this->tableOptions);

        $this->createIndex($this->nameIndex, $this->table, 'name');
        $this->setForeignKeyChecks(true);

        return parent::up();
    }


    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        return $this->insert($this->table, [
            'id'          => 1,
            'name'        => 'Default category',
            'description' => 'Default category',
            'created_at'  => time(),
            'updated_at'  => time(),
        ]);
    }




    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropIndex($this->nameIndex, $this->table);
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }


}
