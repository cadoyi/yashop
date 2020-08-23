<?php

namespace catalog\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\DynamicModel;
use yii\behaviors\TimestampBehavior;
use cando\mongodb\ActiveRecord;
use store\models\Store;
use catalog\models\forms\TypeAttributeForm;
use catalog\models\product\PriceModel;
use catalog\models\product\SkuModel;

/**
 * 产品
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Product extends ActiveRecord
{

    protected $_typeAttributeForm;

    protected $_priceModel;

    protected $_skuModels;


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
            'skus',               // 产品子选项 SKU                
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
        ];
    }



    /**
     * @ineritdoc
     */
    public function rules()
    {
        return [
            [['store_id', 'type_id', 'type_data', 'category_id', 'price', 'cost_price', 'sku', 'stock', 'image', 'galleries', 'options', 'skus'], 'required'],
            [['store_id', 'brand_id', 'type_id', 'weight', 'stock', 'stock_warning', 'virtual_sales', 'category_id'], 'integer'],
            [['price', 'market_price', 'cost_price', 'promote_price', 'rate'], 'number', 'min' => 0 ],
            [['title', 'sku', 'image'], 'string', 'max' => 255],
            [['description', 'meta_keywords', 'meta_description'], 'string'],
            [['promote_start_date', 'promote_end_date'], 'datetime'],
            [['on_sale', 'is_virtual', 'is_part', 'is_hot', 'is_new', 'is_best'], 'boolean'],
            [['type_data'], 'validateTypeData'],
            [['galleries'], 'validateGalleries'],
            [['options'], 'validateOptions'],
            [['skus'], 'validateSkus'],
            [['store_id'], 'exist', 'targetClass' => Store::class, 'targetAttribute' => 'id'],
            [['brand_id'], 'exist', 'targetClass' => Brand::class, 'targetAttribute' => 'id'],
            [['type_id'], 'exist', 'targetClass'  => Type::class, 'targetAttribute' => 'id'],
            [['category_id'], 'exist', 'targetClass' => Category::class, 'targetAttribute' => 'id'],
            [['sku'], 'unique', 'when' => function($model, $attribute) {
                return $model->isAttributeChanged($attribute);
            }],
            [['market_price', 'stock_warning','is_virtual', 'is_part', 'is_hot', 'is_new', 'is_best', 'is_deleted', 'virtual_sales'], 'default', 'value' => 0],
            [['on_sale'], 'default', 'value' => 1],
            [['weight'], 'default', 'value' => 1000],
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
        if(!is_array($this->$attribute)) {
            $this->addError($attribute, 'Invalid data');
        }
    }



    /**
     * 验证 gallery
     * 
     * @param  [type] $attribute [description]
     * @param  [type] $params    [description]
     * @param  [type] $validator [description]
     * @return [type]            [description]
     */
    public function validateGalleries($attribute, $params, $validator)
    {
        if(!is_array($this->$attribute)) {
            $this->addError($attribute, 'Invalid data');
            return;
        }
        foreach($this->$attribute as $image) {
            if(!is_string($image) || !Yii::$app->storage->has($image)) {
                $this->addError($attribute, 'Invalid image');
            }
        }
    }



    /**
     * 验证选项
     * 
     * @param  [type] $attribute [description]
     * @param  [type] $params    [description]
     * @param  [type] $validator [description]
     * @return [type]            [description]
     */
    public function validateOptions($attribute, $params, $validator)
    {
        if(!is_array($this->$attribute)) {
            $this->addError($attribute, 'Invalid data');
            return;
        }
        $_attributes = [];
        foreach($this->$attribute as $i => $data) {
            $model = new DynamicModel([
                'name' => null,
                'values' => [],
                'sort_order' => null,
            ]);
            $model->addRule(['name', 'values'], 'required');
            $model->addRule('name', 'string', ['max' => 32]);
            $model->addRule('values', 'each', [
               'rule' => ['string', 'max' => 255],
            ]);
            $model->addRule('sort_order', 'integer');
            $model->addRule('sort_order', 'default', ['value' => $i ]);
            $result = $model->load($data, '') && $model->validate();
            if(!$result) {
                $errors = $model->getFirstErrors();
                foreach($errors as $error) {
                    $this->addError($attribute, $error); 
                }
                return;
            }
            $_attributes[$i] = $model->attributes;
        }
        $names = ArrayHelper::getColumn($_attributes, 'name');
        if(count($names) !== count(array_unique($names))) {
            $this->addError($attribute, 'Option name must be unique');
            return;
        }
        $this->$attribute = $_attributes;
    }



    /**
     * 验证 sku 数据.
     * 
     * @param  [type] $attribute [description]
     * @param  [type] $params    [description]
     * @param  [type] $validator [description]
     * @return [type]            [description]
     */
    public function validateSkus($attribute, $params, $validator)
    {
        if(!is_array($this->$attribute)) {
            $this->addError($attribute, 'Invalid data');
        }
        $_attributes = [];
        foreach($this->$attribute as $i => $skuData) {
            if(!is_array($skuData)) {
                $this->addError($attribute, 'Invalid data');
                return;
            }
            $model = new DynamicModel([
                'image' => null,
                'sku'   => null,
                'price' => null,
                'stock' => null,
            ]);
            $model->addRule(['sku', 'price', 'stock'], 'required');
            $model->addRule(['image', 'sku'], 'string');
            $model->addRule('price', 'number', ['min' => 0]);
            $model->addRule('stock', 'integer', ['min' => 0]);
            $options = $this->options;
            foreach($options as $option) {
                $model->defineAttribute($option['name'], null);
                $model->defineAttribute($option['name'], 'required');
                $model->addRule($option['name'], 'in', ['range' => $option['values']]);
            }
            $result = $model->load($skuData, '') && $model->validate();
            if(!$result) {
                $errors = $model->getFirstErrors();
                foreach($errors as $error) {
                    $this->addError($attribute, $error);
                    return;
                }
            }
            $_attributes[$i] = $model->attributes;
        }
        $this->$attribute = $_attributes;
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



    
    /**
     * 获取产品类型
     * 
     * @return yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::class, ['id' => 'type_id']);
    }



    /**
     * 获取分类
     * 
     * @return yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }



    /**
     * 获取店铺
     * 
     * @return store
     */
    public function getStore()
    {
         return $this->hasOne(Store::class, ['id' => 'store_id']);
    }



    /**
     * 获取品牌
     * 
     * @return brand
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
    }


    /**
     * 设置产品类型属性表单,用于验证和保存产品类型属性值.
     * 
     * @param TypeAttributeForm $typeAttributeForm 
     */
    public function setTypeAttributeForm( $typeAttributeForm )
    {
        $this->_typeAttributeForm = $typeAttributeForm;
    }



    /**
     * 获取 TypeAttributeForm
     * 
     * @return TypeAttributeForm
     */
    public function getTypeAttributeForm()
    {
        return $this->_typeAttributeForm;
    }


    
    /**
     * 加载产品和属性
     * 
     * @param  array $data  表单数据
     * @return boolean
     */
    public function loadForm( $data )
    {
        $result = true;
        if($form = $this->getTypeAttributeForm()) {
            $result = $form->load($data);
        }
        return $this->load($data) && $result;
    }


    
    /**
     * 验证产品和属性.
     * 
     * @return boolean
     */
    public function validateForm()
    {
        $result = true;
        if($form = $this->getTypeAttributeForm()) {
            $result = $form->validate();
            $this->type_data = $form->getProductTypeData();
        }
        return $this->validate() && $result;
    }



    /**
     * 保存表单
     * 
     * @return boolean
     */
    public function saveForm()
    {
        if(!$this->validateForm()) {
            return false;
        }
        if($form = $this->typeAttributeForm) {
            $this->type_data = $form->getProductTypeData();
        }
        return $this->save();
    }



    /**
     * 获取产品名
     * 
     * @return string
     */
    public function getName()
    {
        return $this->title;
    }



    /**
     * 获取价格模型, 用于计算产品价格
     * 
     * @return priceModel
     */
    public function getPriceModel()
    {
        if(!$this->_priceModel) {
            $this->_priceModel = new PriceModel(['product' => $this]);
        }
        return $this->_priceModel;
    }


    /**
     * 获取 skus 模型
     * 
     * @return array
     */
    public function getSkuModels()
    {
        if(is_null($this->_skuModels)) {
            $this->_skuModels = [];
            foreach($this->skus as $sku) {
                $this->_skuModels[] = new SkuModel($this, $sku);
            }         
        }
        return $this->_skuModels;
    }



    /**
     * 获取 sku 模型
     * 
     * @param  string $sku  SKU 字符串
     * @return skuModel
     */
    public function getSkuModel( $sku )
    {
        $models = $this->getSkuModels();
        foreach($models as $model) {
            if($model->sku === $sku) {
                return $model;
            }
        }
        return null;
    }



    /**
     * 获取 sku 数据.
     * 
     * @return array
     */
    public function getSkusData()
    {
        $data = [];
        $models = $this->getSkuModels();
        foreach($models as $model) {
            $data[] = $model->getData();
        }
        return $data;
    }



    /**
     * 是否有货.
     * 
     * @return boolean
     */
    public function hasStock()
    {
        $hasStock = false;
        foreach($this->getSkuModels() as $model) {
            if($model->hasStock()) {
                $hasStock = true;
            }
        }
        return $hasStock;
    }



    /**
     * 获取最终的价格
     * 
     * @return number
     */
    public function getFinalPrice()
    {
        return $this->getPriceModel()->getFinalPrice();
    }



    /**
     * 获取图片的 URL
     * 
     * @param  [type] $width  [description]
     * @param  [type] $height [description]
     * @return [type]         [description]
     */
    public function getImageUrl( $width = null, $height = null)
    {
        return (string) Yii::$app->storage->getUrl($this->image, $width, $height);
    }

}