<?php

namespace core\models\file;

use Yii;
use yii\base\Component;


/**
 * 配置
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Config extends Component
{

    const CONFIG_FILE_NAME = 'uploader';


    public $id;

    public $config;

    public $path;


    protected $_storage;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->config = Yii::$app->config->getConfig(self::CONFIG_FILE_NAME);
        $this->path   = $this->config->getConfig('paths.' .$this->id);
    }



    /**
     * 获取验证规则。
     * 
     * @return array
     */
    public function getValidators()
    {
        return $this->path->get('validators', []);
    }



    /**
     * 获取配置路径, 如果没有配置，则使用 id 代替
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->path->get('path', $this->id);
    }




    /**
     * 获取上传的类型。
     * 
     * @return string
     */
    public function getType()
    {
        return $this->path->get('type', 'file');
    }




    /**
     * 获取 level
     * 
     * @return int
     */
    public function getLevel()
    {
        return $this->path->get('level', 0);
    }



    /**
     * 获取 resizes 值
     * 
     * @return array
     */
    public function getResizes()
    {
        return $this->path->get('resizes', []);
    }



    /**
     * 获取 redis 组件
     * 
     * @return string|array|redis
     */
    public function getRedis()
    {
        $redis = $this->config->get('redis', 'redis');
        return $this->path->get('redis', $redis);
    }




    /**
     * 获取存储配置。
     * 
     * @return string|array|Storage
     */
    public function getStorage()
    {
        $storage = $this->config->get('storage', 'storage');
        return $this->path->get('storage', $storage);
    }




    /**
     * 是否为图片上传
     * 
     * @return boolean 
     */
    public function isImage()
    {
        return $this->getType() === 'image';
    }




    /**
     * 获取 uploader 选项。
     * 
     * @return array
     */
    public function getUploaderOptions()
    {
        return [
            'type'       => $this->getType(),
            'path'       => $this->getPath(),
            'level'      => $this->getLevel(),
            'validators' => $this->getValidators(),
            'resizes'    => $this->getResizes(),
            'redis'      => $this->getRedis(),
            'storage'    => $this->getStorage(),
        ];
    }


 
}