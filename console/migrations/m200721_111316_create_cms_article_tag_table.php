<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%cms_article_tag}}`.
 */
class m200721_111316_create_cms_article_tag_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%cms_article_tag}}';

    public $articleTable = '{{%cms_article}}';

    public $tagTable = '{{%cms_tag}}';


    public $pkName = 'PK_CMS_ARTICLE_TAG_ARTICLE_ID_TAG_ID';

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'article_id' => $this->integer()->unsigned()->notNull(),
            'tag_id' => $this->integer()->unsigned()->notNull(),
        ], $this->tableOptions);


        $this->addPrimaryKey($this->pkName, $this->table, ['article_id', 'tag_id']);
        $this->addFk($this->table, 'article_id', $this->articleTable, 'id');
        $this->addFk($this->table, 'tag_id', $this->tagTable, 'id');
        $this->createIndex('IDX_CMS_ARTICLE_TAG_TAG_ID_ARTICLE_ID', $this->table, ['tag_id', 'article_id']);

        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropIndex('IDX_CMS_ARTICLE_TAG_TAG_ID_ARTICLE_ID', $this->table);
        $this->dropFk($this->table, 'tag_id', $this->tagTable, 'id');
        $this->dropFk($this->table, 'article_id', $this->articleTable, 'id');
        $this->dropPrimaryKey($this->pkName, $this->table);
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
