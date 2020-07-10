<?php

namespace admin\models;

use Yii;
use cando\db\ActiveRecord;

/**
 * 管理员日志表
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Log extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_log}}';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'action', 'description'], 'required'],
            [['user_id'], 'integer'],
            [['params'], 'default', 'value' => []],
            [['action', 'description', 'ip'], 'string', 'max' => 255],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
           'action'     => Yii::t('app', 'Action'),
           'message'    => Yii::t('app', 'Message'),
           'ip'         => Yii::t('app', 'Ip'),
           'created_at' => Yii::t('app', 'Time'),
           'nickname'   => Yii::t('app', 'Nickname'),
        ];
    }


    /**
     * @inheritdoc
     */
    public static function serializedFields()
    {
        return ['params'];
    }

    

    /**
     * 获取消息
     * 
     * @return  string 消息串
     */
    public function getMessage()
    {
        if(empty($this->params)) {
            $this->params = [];
        }
        return Yii::t('app', $this->description, $this->params);
    }

}