<?php

use cando\db\Migration;

/**
 * Class m200711_114827_insert_customer_group
 */
class m200711_031927_insert_customer_group extends Migration
{

    public $table = '{{%customer_group}}';


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert($this->table, [
            'id'         => 1,
            'name'       => 'default',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }



    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete($this->table, ['id' => 1]);
    }

}
