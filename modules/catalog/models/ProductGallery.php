<?php

namespace catalog\models;

use Yii;
use cando\db\ActiveRecord;


/**
 * 产品画册
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductGallery extends ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_gallery}}';
    }




    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'image'], 'required'],
            [['product_id', 'sort_order'], 'integer'],
            [['image'], 'string', 'max' => 255],
            [['sort_order'], 'default', 'value' => 1],
        ];
    }




    /**
     * 获取 product
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
    public function setProduct(Product $product)
    {
        $this->product_id = $product->id;
        $this->populateRelation('product', $product);
    }



    /**
     * 获取 图片 URL
     * 
     * @param  int  $width   图片宽度
     * @param  int $height   图片高度
     * @return string
     */
    public function getImageUrl($width = null, $height = null)
    {
        return (string) Yii::$app->storage->getUrl($this->image, $width, $height);
    }



}