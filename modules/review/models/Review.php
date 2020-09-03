<?php

namespace review\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\mongodb\ActiveRecord;

/**
 * 产品评价表
 *
 * @author  zhangyang <zhangyancado@qq.com>
 */
class Review extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'review';
    }


    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'customer_id',
            'customer_nickname',
            'customer_avatar',
            'product_id',
            'product_sku',
            'order_id',
            'score',
            'content',
            'images',
            'addition_content',
            'addition_images',
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
            [['customer_id', 'product_id', 'order_id', 'score'], 'required'],
            [['customer_id', 'order_id'], 'integer'],
            [['score'], 'integer', 'min' => 1, 'max' => 5],
            [['product_id'], 'integer'],
            [['customer_nickname', 'customer_avatar'], 'string', 'max' => 255],
            [['content', 'addition_content'], 'string'],
            [['product_sku', 'images', 'addition_images'], 'safe'],
            [['score'], 'default', 'value' => 5],
        ];
    }



    /**
     * @inheritdoc
     */
    protected function labels()
    {
        return [
           '_id'              => 'Id',
           'score'            => 'Review score',
           'content'          => 'Review content',
           'images'           => 'Review content images',
           'addition_content' => 'Addition review content',
           'addition_images'  => 'Addition review conent images',
           'created_at'       => 'Review time',
           'updated_at'       => 'Addition review time',
        ];
    }




}