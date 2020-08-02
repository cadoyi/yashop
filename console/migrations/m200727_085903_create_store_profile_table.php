<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%store}}`.
 */
class m200727_085903_create_store_profile_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%store_profile}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique()->comment('店铺名称'),
            'description' => $this->text()->comment('店铺简述'),
            'logo' => $this->string()->comment('店铺 logo'),
            'type' => $this->tinyInteger()->unsigned()->notNull()->comment('店铺类型: 1: 个人, 2: 公司'),
            'company_name' => $this->string()->comment('公司名称'),
            'legal_person' => $this->string(32)->comment('法人'),
            'phone'  => $this->string(13)->notNull()->comment('手机号'),
            'status' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(1)->comment('店铺状态, 1: 默认状态审核中'),
            'is_platform' => $this->boolean()->notNull()->defaultValue(0)->comment('是否平台店铺'),
            'note' => $this->text()->comment('备注'),
            'created_at' => $this->inttime()->comment('开通时间'),
            'updated_at' => $this->inttime()->comment('更改时间'),
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
