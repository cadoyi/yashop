<?php

namespace checkout\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\mongodb\ActiveRecord;

/**
 * 报价地址
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class QuoteAddress extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'checkout_quote_address';
    }


    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'quote_id',
            'address_id',
            'tag',
            'name',
            'phone',
            'region',
            'city',
            'area',
            'street',
            'zipcode',
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
           [['quote_id'], 'required'],
           [['address_id'], 'integer'],
           [['name', 'region', 'city', 'area', 'zipcode'], 'string', 'max' => 255],
           [['phone'], 'phone'],
           [['street'], 'string'],
        ];
    }


 
    /**
     * @inheritdoc
     */
    public function labels()
    {
        return [];
    }


}