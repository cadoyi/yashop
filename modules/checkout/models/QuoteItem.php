<?php

namespace checkout\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;
use catalog\models\Product;
use catalog\models\ProductSku;

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
    public static function tableName()
    {
        return '{{%checkout_quote_item}}';
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
            [['quote_id', 'product_id', 'qty', 'product_sku_id'], 'integer'],
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
        return $this->hasOne(Quote::class, ['id' => 'quote_id']);
    }



    /**
     * 获取产品实例.
     * 
     * @return yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
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
     * 获取产品 SKU
     * 
     * @return yii\db\ActiveQuery
     */
    public function getProductSku()
    {
        return $this->hasOne(ProductSku::class, ['id' => 'product_sku_id']);
    }



    /**
     * 设置产品 Sku
     * 
     * @param ProductSku $productSku 
     */
    public function setProductSku(ProductSku $productSku)
    {
        $this->product_sku_id = $productSku->id;
        $this->populateRelation('productSku', $productSku);
    }




    /**
     * 获取总价
     * 
     * @return string
     */
    public function getGrandTotal()
    {
        $qty = $this->qty;
        $product = $this->product;
        $productSku = $this->productSku;
        if($productSku instanceof ProductSku) {
            return $productSku->getFinalPrice($qty);
        }
        return $product->getFinalPrice($qty);
    }

}