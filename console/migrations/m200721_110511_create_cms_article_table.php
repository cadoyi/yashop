<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%cms_article}}`.
 */
class m200721_110511_create_cms_article_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%cms_article}}';

    public $categoryTable = '{{%cms_category}}';


    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'    => $this->primaryKey(),
            'title' => $this->string()->notNull()->comment('文章标题'),
            'content' => $this->string()->notNull()->comment('文章内容'),
            'category_id' => $this->fk()->comment('文章分类'),
            'author'      => $this->string()->notNull()->comment('作者'),
            'meta_keywords' => $this->text()->comment('关键字'),
            'meta_description' => $this->text()->comment('元描述'),
            'created_at' => $this->inttime(),
            'updated_at' => $this->inttime(),
        ], $this->tableOptions);

        $this->addFk($this->table, 'category_id', $this->categoryTable, 'id');

        $this->createIndex('IDX_CMS_ARTICLE_AUTHOR', $this->table, 'author');
        $this->createIndex('IDX_CMS_ARTICLE_TITLE', $this->table, 'title');
        $this->setForeignKeyChecks(true);
    }



    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropFk($this->table, 'category_id', $this->categoryTable, 'id');
        $this->dropIndex('IDX_CMS_ARTICLE_TITLE', $this->table);
        $this->dropIndex('IDX_CMS_ARTICLE_AUTHOR', $this->table);
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }

    



}
