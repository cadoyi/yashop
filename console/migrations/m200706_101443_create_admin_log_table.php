<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%admin_log}}`.
 */
class m200706_101443_create_admin_log_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%admin_log}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'          => $this->primaryKey(),
            'user_id'     => $this->fk(),
            'action'      => $this->varchar()->notNull(),
            'description' => $this->varchar()->notNull(),
            'params'      => $this->text()->defaultValue(null),
            'ip'          => $this->string()->notNull()->defaultValue('0.0.0.0'),
            'created_at'  => $this->inttime(),
        ], $this->tableOptions);
        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }

    
}
