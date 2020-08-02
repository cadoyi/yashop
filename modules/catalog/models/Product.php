<?php

namespace catalog\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\mongodb\ActiveRecord;
use store\models\Store;

/**
 * 产品
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Product extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'catalog_product';
    }



    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',                // 主键值
            'store_id',           // 店铺 ID
            'brand_id',           // 品牌 ID
            'type_id',            // 产品类型 ID
            'type_data',          // 产品类型数据
            'category_id',       // 分类 ID
            'title',              // 产品名称
            'description',        // 产品描述
            'price',              // 产品售价
            'market_price',       // 市场售价
            'cost_price',         // 成本价格
            'promote_price',      // 促销价
            'promote_start_date', // 促销开始时间
            'promote_end_date',   // 促销结束时间
            'weight',             // 产品重量
            'rate',               // 运费
            'meta_keywords',      // 元关键字
            'meta_description',   // 元描述
            'sku',                // 产品 sku
            'stock',              // 库存
            'stock_warning',      // 库存预警数量
            'on_sale',            // 上架
            'is_virtual',         // 是否虚拟产品
            'is_part',            // 是否配件
            'is_best',            // 是否精品
            'is_hot',             // 是否热销
            'is_new',             // 是否新品
            'is_deleted',         // 是否被删除
            'image',              // 头图
            'galleries',          // 产品相册
            'virtual_sales',      // 虚拟销量
            'real_sales',         // 真实销量
            'options',            // 产品选项
            'created_at',         // 添加时间
            'updated_at',         // 更新时间
            'deleted_at',         // 删除时间

        ];
    }



    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'timestamp' => TimestampBehavior::class,
        ]);
    }


    /**
     * @inheritdoc
     */
    public function defaultValues()
    {
        return [
            'stock_warning'      => 0,   //默认库存预警值为 10 件
            'market_price'       => 0,
            'cost_price'         => 0,
            'promote_price'      => null,
            'promote_start_date' => null,
            'promote_end_date'   => null,
            'rate'               => 0,
            'on_sale'            => 1,
            'is_virtual'         => 0, 
            'is_part'            => 0, 
            'is_hot'             => 0, 
            'is_new'             => 0, 
            'is_best'            => 0,
            'is_deleted'         => 0,
            'virtual_sales'      => 0,
            'real_sales'         => 0,
        ];
    }



    /**
     * @ineritdoc
     */
    public function rules()
    {
        return [
            [['store_id', 'type_id', 'type_data', 'category_id', 'price', 'cost_price', 'weight', 'sku', 'stock', 'image', 'galleries', 'options'], 'required'],
            [['store_id', 'brand_id', 'type_id', 'weight', 'stock', 'stock_warning', 'virtual_sales', 'real_sales', 'category_id'], 'integer'],
            [['price', 'market_price', 'cost_price', 'promote_price', 'rate'], 'number', 'min' => 0 ],
            [['title', 'sku', 'image'], 'string', 'max' => 255],
            [['type_data', 'category_ids', 'description', 'meta_keywords', 'meta_description', 'galleries', 'options'], 'string'],
            [['promote_start_date', 'promote_end_date'], 'datetime'],
            [['on_sale', 'is_virtual', 'is_part', 'is_hot', 'is_new', 'is_best'], 'boolean'],
            [['type_data'], 'validateTypeData'],
            [['galleries'], 'validateGalleries'],
            [['options'], 'validateOptions'],
            [['store_id'], 'exist', 'targetClass' => Store::class, 'targetAttribute' => 'id'],
            [['brand_id'], 'exist', 'targetClass' => Brand::class, 'targetAttribute' => 'id'],
            [['type_id'], 'exist', 'targetClass'  => Type::class, 'targetAttribute' => 'id'],
            [['category_id'], 'exist', 'targetClass' => Category::class, 'targetAttribute' => 'id'],
            [['sku'], 'unique', 'when' => function($model, $attribute) {
                return $model->isAttributeChanged($attribute);
            }],
            [['market_price', 'stock_warning','is_virtual', 'is_part', 'is_hot', 'is_new', 'is_best', 'is_deleted', 'virtual_sales', 'real_sales'], 'default', 'value' => 0],
            [['on_sale'], 'default', 'value' => 1],
        ];
    }


    /**
     * 验证类型数据
     * 
     * @param  [type] $attribute [description]
     * @param  [type] $params    [description]
     * @param  [type] $validator [description]
     * @return [type]            [description]
     */
    public function validateTypeData($attribute, $params, $validator)
    {

    }



    public function validateGalleries($attribute, $params, $validator)
    {

    }


    public function validateOptions($attribute, $params, $validator)
    {

    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id'       => Yii::t('app', 'Id'),                // 主键值
            'store_id'  => Yii::t('app', 'Store'),           // 店铺 ID
            'brand_id'  => Yii::t('app', 'Brand'),           // 品牌 ID
            'type_id'   => Yii::t('app', 'Product type'),            // 产品类型 ID
            'type_data' => Yii::t('app', 'Product type data'),          // 产品类型数据
            'category_id' => Yii::t('app', 'Product category'),       // 分类 ID
            'title'        => Yii::t('app', 'Product name'),              // 产品名称
            'description'  => Yii::t('app', 'Product description'),        // 产品描述
            'price'        => Yii::t('app', 'Product price'),              // 产品售价
            'market_price' => Yii::t('app', 'Product market price'),       // 市场售价
            'cost_price'   => Yii::t('app', 'Product cost price'),         // 成本价格
            'promote_price' => Yii::t('app', 'Product promotion price'),      // 促销价
            'promote_start_date' => Yii::t('app', 'Product promotion price start date'), // 促销开始时间
            'promote_end_date'  => Yii::t('app', 'Product promotion price end date'),   // 促销结束时间
            'weight'           => Yii::t('app', 'Product weight'), // 产品重量
            'rate'             => Yii::t('app', 'Product shipping rate'),  // 运费
            'meta_keywords'    => Yii::t('app', 'Meta keywords'),  // 元关键字
            'meta_description' => Yii::t('app', 'Meta description'),   // 元描述
            'sku'             => Yii::t('app', 'Product sku'),         // 产品 sku
            'stock'           => Yii::t('app', 'Product stock'),       // 库存
            'stock_warning'   => Yii::t('app', 'Show warning when stock too low'),     // 库存预警数量
            'on_sale'         => Yii::t('app', 'This product is on sale'),            // 上架
            'is_virtual'      => Yii::t('app', 'This is a virtual product'),     // 是否虚拟产品
            'is_part'         => Yii::t('app', 'This is a part of product'),            // 是否配件
            'is_best'          => Yii::t('app', 'This is a best sale product'),    // 是否精品
            'is_hot'           => Yii::t('app', 'This is a hot sale product'),   // 是否热销
            'is_new'           => Yii::t('app', 'This is a new product'),             // 是否新品
            'is_deleted'       => Yii::t('app', 'Is this a deleted product'),         // 是否被删除
            'image'            => Yii::t('app', 'Product image'),              // 头图
            'galleries'        => Yii::t('app', 'Product galleries'),          // 产品相册
            'virtual_sales'    => Yii::t('app', 'Virtual sales'),      // 虚拟销量
            'real_sales'       => Yii::t('app', 'Real sales'),         // 真实销量
            'options'          => Yii::t('app', 'Product options'),    // 产品选项
            'created_at'       => Yii::t('app', 'Created at'),         // 添加时间
            'updated_at'       => Yii::t('app', 'Updated at'),         // 更新时间
            'deleted_at'       => Yii::t('app', 'Deleted at'),         // 删除时间
        ];
    }



    /**
     * 进行虚拟删除
     * 
     * @return boolean
     */
    public function virtualDelete()
    {
        $this->is_deleted = true;
        $this->deleted_at = time();
        return $this->save();
    }


}