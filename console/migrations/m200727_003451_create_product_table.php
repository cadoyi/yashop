<?php

use cando\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m200727_003451_create_product_table extends Migration
{

    /**
     * @type string 表名称
     */
    public $table = '{{%product}}';

    public $typeTable = '{{%catalog_type}}';

    public $categoryTable = '{{%catalog_category}}';

    public $brandTable = '{{%catalog_brand}}';

    public $storeTable = '{{%store_profile}}';



    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->setForeignKeyChecks(false);
        $this->createTable($this->table, [
            'id'          => $this->primaryKey(),
            'store_id'    => $this->fk(false)->comment('Store ID'),
            'category_id' => $this->fk(false)->comment('Category ID'),
            'brand_id'    => $this->fk(false)->comment('Brand ID'),
            'type_id'     => $this->fk(false)->comment('产品类型 ID'),
            'title'       => $this->string()->notNull()->comment('产品名'),
            'description' => $this->text()->comment('产品描述'),
            'sku'         => $this->string()->notNull()->unique()->comment('产品 SKU'),
            'image'       => $this->string()->notNull()->comment('产品图'),
            'price'       => $this->money()->notNull()->comment('产品价格'),
            'market_price' => $this->money()->comment('市场价'),
            'cost_price'   => $this->money()->comment('成本价'),
            'promote_price' => $this->money()->comment('促销价'),
            'promote_start_date' => $this->datetime()->comment('促销价起始时间'),
            'promote_end_date'   => $this->datetime()->comment('促销价结束时间'),
            'weight'        => $this->decimal(12,2)->notNull()->defaultValue(0)->comment('产品重量'),
            'weight_unit'   => $this->varchar(8)->notNull()->comment('产品重量单位'),
            'rate'          => $this->money()->notNull()->defaultValue(0)->comment('运费'),
            'status'        => $this->boolean()->notNull()->defaultValue(1)->comment('产品状态'),
            'is_selectable' => $this->boolean()->notNull()->defaultValue(1)->comment('是否有可选选项'),
            'is_virtual'    => $this->boolean()->notNull()->defaultValue(0)->comment('是否虚拟产品'),
            'is_best'       => $this->boolean()->notNull()->defaultValue(0)->comment('是否精品'),
            'is_hot'        => $this->boolean()->notNull()->defaultValue(0)->comment('是否热销'),
            'is_new'        => $this->boolean()->notNull()->defaultValue(0)->comment('是否新品'),
            'is_deleted'    => $this->boolean()->notNull()->defaultValue(0)->comment('是否已删除'),
            'created_at'    => $this->inttime(),
            'updated_at'    => $this->inttime(),
            'deleted_at'    => $this->inttime(),
        ], $this->tableOptions);


        $this->addFk($this->table, 'category_id', $this->categoryTable, 'id', 'SET NULL');
        $this->addFk($this->table, 'brand_id', $this->brandTable, 'id', 'SET NULL');
        $this->addFk($this->table, 'store_id', $this->storeTable, 'id', 'SET NULL');
        $this->addFk($this->table, 'type_id', $this->typeTable, 'id', 'SET NULL');
        $this->createIndex('IDX_PRODUCT_SKU', $this->table, 'sku');
        $this->createIndex('IDX_PRODUCT_TITLE', $this->table, 'title');
        $this->setForeignKeyChecks(true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->setForeignKeyChecks(false);
        $this->dropIndex('IDX_PRODUCT_SKU', $this->table);
        $this->dropIndex('IDX_PRODUCT_TITLE', $this->table);
        $this->dropFk($this->table, 'category_id', $this->categoryTable, 'id');
        $this->dropFk($this->table, 'brand_id', $this->brandTable, 'id');
        $this->dropFk($this->table, 'store_id', $this->storeTable, 'id');
        $this->dropFk($this->table, 'type_id', $this->typeTable, 'id');
        $this->dropTable($this->table);
        $this->setForeignKeyChecks(true);
    }
}
