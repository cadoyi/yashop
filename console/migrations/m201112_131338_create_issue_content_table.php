<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%issue_content}}`.
 */
class m201112_131338_create_issue_content_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%issue_content}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'          => $this->primaryKey(),
            'category_id' => $this->fk(),
            'menu_id'     => $this->fk(),
            'title'       => $this->string()->notNull(),
            'content'     => $this->text(),
            'is_deleted'  => $this->boolean()->notNull()->defaultValue(0),
            'created_at'  => $this->inttime(),
            'updated_at'  => $this->inttime(),
        ], $this->tableOptions);

        $this->createIdx($this->table, ['menu_id', 'category_id']);
        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropIdx($this->table, ['menu_id', 'category_id']);
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
