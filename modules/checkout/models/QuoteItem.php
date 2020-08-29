<?php

namespace checkout\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\mongodb\ActiveRecord;
use catalog\models\Product;
use yii\mongodb\validators\MongoIdValidator;

/**
 * 报价项目
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class QuoteItem extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'checkout_quote_item';
    }



    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
           '_id',
           'quote_id',
           'product_id',
           'product_sku',
           'qty',
           'created_at',
           'updated_at',
        ];
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
            [['quote_id', 'product_id', 'qty'], 'required'],
            [['quote_id', 'product_id'], MongoIdValidator::class],
            [[ 'product_sku'], 'string'],
            [['qty'], 'integer'],
        ];
    }



    /**
     * @inheritdoc
     */
    public function labels()
    {
        return [];
    }



    /**
     * 设置 quote 关联
     * 
     * @param Quote $quote 
     */
    public function setQuote( Quote $quote )
    {
        $this->quote_id =  $quote->id;
        $this->populateRelation('quote', $quote);
    }



    /**
     * 获取 quote
     *  
     * @return 
     */
    public function getQuote()
    {
        return $this->hasOne(Quote::class, ['_id' => 'quote_id']);
    }



    /**
     * 获取产品实例.
     * 
     * @return yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['_id' => 'product_id']);
    }


    
    /**
     * 设置 product
     * 
     * @param Product $product 
     */
    public function setProduct( Product $product )
    {
        $this->product_id = $product->id;
        $this->populateRelation('product', $product);
    }



    /**
     * 获取 sku 模型
     * 
     * @return SkuModel
     */
    public function getSkuModel()
    {
        if(!($product = $this->product)) {
            return null;
        }
        if($this->product_sku) {
            $skuModel = $this->product->getSkuModel($this->product_sku);
            return $skuModel;
        }
        return $product;
    }

}