<?php

namespace catalog\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;
use store\models\Store;
use catalog\models\product\PriceModel;

/**
 * 产品表
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Product extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product}}';
    }



    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'timestamp' => [
                 'class' => TimestampBehavior::class,
            ],
        ]);
    }



    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_id', 'category_id', 'type_id', 'title', 'sku', 'image', 'price', 'weight_unit'], 'required'],
            [['store_id', 'category_id', 'brand_id', 'type_id'], 'integer'],
            [['title', 'sku', 'image'], 'string', 'max' => 255],
            [['weight_unit'], 'string', 'max' => 8],
            [['description', 'meta_keywords', 'meta_description'], 'string'],
            [['price', 'market_price', 'cost_price', 'promote_price', 'weight', 'rate'], 'number'],
            [['promote_start_date', 'promote_end_date'], 'datetime'],
            [['status', 'is_selectable', 'is_virtual', 'is_best', 'is_hot', 'is_new'], 'boolean'],

            [['sku'], 'unique', 'when' => function($model, $attribute) {
                return $model->isAttributeChanged($attribute);
            }],
            ['store_id', 'exist', 'targetClass' => Store::class, 'targetAttribute' => 'id'],
            [['category_id'], 'exist', 'targetClass' => Category::class, 'targetAttribute' => 'id'],
            [['brand_id'], 'exist', 'targetClass' => Brand::class, 'targetAttribute' => 'id'],
            [['type_id'], 'exist', 'targetClass' => Type::class, 'targetAttribute' => 'id'],

            [['status', 'is_selectable'], 'default', 'value' => 1],
            [['weight', 'rate', 'is_best', 'is_hot', 'is_new', 'is_virtual', 'deleted_at'], 'default', 'value' => 0],
            
        ];
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
            'weight_unit'      => Yii::t('app', 'Weight unit'),   // 重量单位
            'rate'             => Yii::t('app', 'Product shipping rate'),  // 运费
            'meta_keywords'    => Yii::t('app', 'Meta keywords'),  // 元关键字
            'meta_description' => Yii::t('app', 'Meta description'),   // 元描述
            'sku'             => Yii::t('app', 'Product sku'),         // 产品 sku
            'on_sale'         => Yii::t('app', 'This product is on sale'),            // 上架
            'is_virtual'      => Yii::t('app', 'This is a virtual product'),     // 是否虚拟产品
            'is_part'         => Yii::t('app', 'This is a part of product'),            // 是否配件
            'is_best'          => Yii::t('app', 'This is a best sale product'),    // 是否精品
            'is_hot'           => Yii::t('app', 'This is a hot sale product'),   // 是否热销
            'is_new'           => Yii::t('app', 'This is a new product'),             // 是否新品
            'is_deleted'       => Yii::t('app', 'Is this a deleted product'),         // 是否被删除
            'is_selectable'    => Yii::t('app', 'This product has options'),
            'image'            => Yii::t('app', 'Product image'),              // 头图
            'created_at'       => Yii::t('app', 'Created at'),         // 添加时间
            'updated_at'       => Yii::t('app', 'Updated at'),         // 更新时间
            'deleted_at'       => Yii::t('app', 'Deleted at'),         // 删除时间
        ];
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
     * 设置 catalog type
     */
    public function setType(Type $type)
    {
        $this->type_id = $type->id;
        $this->populateRelation('type', $type);
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
     * 设置分类
     * 
     */
    public function setCategory(Category $category)
    {
        $this->category_id = $category->id;
        $this->populateRelation('category', $category);
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
     * 获取销售数据
     * 
     * @return yii\db\ActiveQuery
     */
    public function getSalesData()
    {
        return $this->hasOne(ProductSales::class, ['product_id' => 'id'])
            ->inverseOf('product');
    }



    /**
     * 获取库存
     * 
     * @return yii\db\ActiveQuery
     */
    public function getInventory()
    {
        return $this->hasOne(ProductInventory::class, ['product_id' => 'id'])
            ->inverseOf('product');
    }



    /**
     * 获取产品画册
     * 
     * @return yii\db\ActiveQuery[]
     */
    public function getGalleries()
    {
        return $this->hasMany(ProductGallery::class, ['product_id' => 'id'])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
            ->indexBy('id')
            ->inverseOf('product');
    }



    /**
     * 获取产品选项.
     * 
     * @return yii\db\ActiveQuery[]
     */
    public function getOptions()
    {
        return $this->hasMany(ProductOption::class, ['product_id' => 'id'])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
            ->indexBy('id')
            ->inverseOf('product');
    }



    /**
     * 获取产品 SKU
     * 
     * @return yii\db\ActiveQuery[]
     */
    public function getSkus()
    {
        return $this->hasMany(ProductSku::class, ['product_id' => 'id'])
            ->indexBy('id')
            ->inverseOf('product');
    }



    /**
     * 获取 sku 模型
     * 
     * @param  int  $id  产品 SKU id
     * @return ProductSku
     */
    public function getSku($id)
    {
        if(array_key_exists($id, $this->skus)) {
            return $this->skus[$id];
        }
        return null;
    }




    /**
     * 获取产品类型
     * 
     * @return yii\db\ActiveQuery[]
     */
    public function getProductTypes()
    {
        return $this->hasMany(ProductType::class, ['product_id' => 'id'])
           ->indexBy('type_attribute_id')
           ->inverseOf('product');
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
     * 设置产品名
     * 
     * @param string $name
     */
    public function setName( $name )
    {
        $this->title = $name;
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
     * 获取销售数量
     *
     * @param  boolean $includeVirtual  是否包含虚拟销量
     * @return int
     */
    public function getSalesCount($includeVirtual = true)
    {
        return $this->salesData->getSalesCount($includeVirtual);
    }



    /**
     * 是否有库存
     * 
     * @return boolean
     */
    public function hasStock()
    {
        if($this->is_selectable) {
            foreach($this->skus as $sku) {
                if($sku->hasStock()) {
                    return true;
                }
            }
            return false;
        } else {
            return $this->inventory->hasStock();
        }
    }



    /**
     * 获取最大可销售的数量
     * 
     * @return int
     */
    public function getMaxStock()
    {
        if($this->hasStock()) {
            if($this->is_selectable) {
                $max = 0;
                foreach($this->skus as $sku) {
                    $max = max($max, $sku->qty);
                }
                return $max;
            }
            return $this->inventory->qty;
        }
        return 0;
    }



    /**
     * 获取库存数量.
     * 
     * @return int
     */
    public function getQty()
    {
        return $this->inventory->qty;
    }



    /**
     * 扣除库存.
     * 
     * @param  int  $qty  库存
     * @return boolean
     */
    public function decrQty( $qty )
    {
        return $this->inventory->decrQty($qty);
    }



    /**
     * 获取价格模型
     * 
     * @return PriceModel
     */
    public function getPriceModel()
    {
        return new PriceModel(['product' => $this]);
    }



    /**
     * 获取最终价格
     * 
     * @param  integer $qty 数量
     * @return price
     */
    public function getFinalPrice( $qty = 1)
    {
        return $this->getPriceModel()->getFinalPrice($qty);
    }



    /**
     * 是否可售卖
     * 
     * @return boolean
     */
    public function isOnSale()
    {
        $onSale = !$this->is_deleted && $this->status == 1;
        return $onSale && $this->hasStock();
    }


}