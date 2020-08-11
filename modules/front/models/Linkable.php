<?php

namespace front\models;

use Yii;
use cando\mongodb\ActiveRecord;

/**
 * 链接配置
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Linkable extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'front_linkable';
    }


    
    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
           '_id',
           'type',
           'link_id',
           'data',
        ];
    }

    


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['type', 'link_id'], 'required'],
           [['type', 'link_id'], 'string'],
           [['data'], 'validateData'],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id'     => Yii::t('app', 'Id'),
            'type'    => Yii::t('app', 'Link type'),
            'link_id' => Yii::t('app', 'Link id'),
            'data'    => Yii::t('app', 'Data'),
        ];
    }



}