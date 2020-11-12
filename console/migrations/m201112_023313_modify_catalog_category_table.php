<?php

use cando\db\Migration;
use yii\db\Query;

/**
 * Class m201112_023313_modify_catalog_category_table
 */
class m201112_023313_modify_catalog_category_table extends Migration
{

    public $table = '{{%catalog_category}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->begin();
        $this->addColumn($this->table, 'path', $this->string());
        $this->addColumn($this->table, 'level', $this->tinyInteger()->notNull()->defaultValue(1));

        $this->createIdx($this->table, ['path', 'level']);
        $this->end();
        parent::up();
    }


    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $query = new Query();
        $all = $query->from($this->table)
            ->indexBy('id')
            ->all($this->db);


        foreach($all as $id => $row) {
            $this->buildPath($all, $id);
        }
        foreach($all as $id => $row) {
            $this->update($this->table, $row, ['id' => $id]);
        }
    }


    public function buildPath(&$all, $id)
    {
        $row = &$all[$id];
        $parent_id = $row['parent_id'];
        if(!$parent_id) {
            $row['path'] = $row['id'];
            $row['level'] = 1;
        } else {
            $parentRow = &$all[$parent_id];
            if(!isset($parentRow['path'])) {
                $this->buildPath($all, $parent_id);
            }
            $row['path'] = $parentRow['path']. '/' . $row['id'];
            $row['level'] = $parentRow['level'] + 1;
        }
    }



    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->begin();
        $this->dropIdx($this->table, ['path', 'level']);
        $this->dropColumn($this->table, 'path');
        $this->dropColumn($this->table, 'level');
        $this->end();
    }


}
