<?php

namespace wishlist\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\mongodb\validators\MongoIdValidator;
use cando\db\ActiveRecord;
use catalog\models\Product;

/**
 * wishlist item
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class WishlistItem extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wishlist_item}}';
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
            [['wishlist_id', 'product_id'], 'required'],
            [['wishlist_id', 'product_id'], 'integer'],
        ];
    }



    /**
     * @inheritdoc
     */
    public function labels()
    {
        return [
            'wishlist_id' => 'Wishlist',
            'product_id'  => 'Product',
        ];
    }



    /**
     * 设置 wishlist
     * 
     * @param Wishlist $wishlist
     */
    public function setWishlist(Wishlist $wishlist)
    {
         $this->wishlist_id = $wishlist->id;
         $this->populateRelation('wishlist', $wishlist);
    }




    /**
     * 获取 wishlist
     * 
     * @return yii\db\ActiveQuery
     */
    public function getWishlist()
    {
        return $this->hasOne(Wishlist::class, ['id' => 'wishlist']);
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
     * 获取 product
     * 
     * @return yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }





    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        $result = parent::afterSave($insert, $changedAttributes);
        $this->wishlist->addItemCount();
        return $result;
    }



    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        $result = parent::afterDelete();
        $this->wishlist->addItemCount(-1);
        return $result;
    }

}