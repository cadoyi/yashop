<?php

namespace store\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use cando\db\ActiveRecord;

/**
 * 店铺信息
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Store extends ActiveRecord
{

    /**
     * @var  int 公司类型
     */
    const TYPE_COMPANY = 1;

    /**
     * @var  int 个人类型.
     */
    const TYPE_INDIVIDUAL = 2;


    const STATUS_SUBMITTED = 1;            // 已提交
    const STATUS_REVIEWING = 2;            // 审核中
    const STATUS_REVIEW_SUCCESSFUL = 3;    // 审核成功
    const STATUS_REVIEW_FAILED = 4;        // 审核失败




    /**
     * status hash options
     * 
     * @return array
     */
    public static function statusHashOptions()
    {
        return [
            static::STATUS_SUBMITTED      => Yii::t('app', 'Submitted'),
            static::STATUS_REVIEWING      => Yii::t('app', 'Reviewing'),
            static::STATUS_REVIEW_SUCCESSFUL => Yii::t('app', 'Review successful'),
            static::STATUS_REVIEW_FAILED    => Yii::t('app', 'Review failed'),
        ];
    }



    /**
     * type hash options
     * 
     * @return array
     */
    public static function typeHashOptions()
    {
        return [
           static::TYPE_COMPANY    => Yii::t('app', 'Company'),
           static::TYPE_INDIVIDUAL => Yii::t('app', 'Individual'),
        ];
    }






    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%store_profile}}';
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
            [
                [
                    'name', 
                    'description', 
                    'type', 
                    'legal_person',
                    'phone',
                ], 
                'required',
            ],
            [['name', 'logo', 'company_name', 'legal_person'], 'string', 'max' => 255],
            [['description', 'note'], 'string'],
            [['phone'], 'phone'],
            [['is_platform'], 'boolean'],
            [['type'], 'in', 'range' => array_keys(static::typeHashOptions())],
            [['status'], 'in', 'range' => array_keys(static::statusHashOptions())],
            [['status'], 'default', 'value' => 1],
            [['is_platform'], 'default', 'value' => 0 ],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'           => Yii::t('app', 'Id'),
            'name'         => Yii::t('app', 'Store name'),
            'description'  => Yii::t('app', 'Store description'),
            'logo'         => Yii::t('app', 'Logo'),
            'type'         => Yii::t('app', 'Store type'),
            'company_name' => Yii::t('app', 'Company name'),
            'legal_person' => Yii::t('app', 'Legal person'),
            'phone'        => Yii::t('app', 'Mobile phone number'),
            'status'       => Yii::t('app', 'Status'),
            'is_platform'  => Yii::t('app', 'Is platform store'),
            'note'         => Yii::t('app', 'Note'),
            'created_at'   => Yii::t('app', 'Created at'),
            'updated_at'   => Yii::t('app', 'Updated at'), 
        ];
    }




    /**
     * 选择店铺
     * 
     * @return array
     */
    public static function hashOptions()
    {
        return static::find()
           ->select(['name'])
           ->indexBy('id')
           ->tableCache()
           ->column();
    }

}