<?php

namespace core\models\file;

use Yii;
use yii\base\Component;
use yii\web\UploadedFile;
use core\models\file\exceptions\UploadException;
use core\models\file\exceptions\UploadUserException;
use cando\storage\Uploader as StorageUploader;

/**
 * file upload 
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Uploader extends Component
{
    
    public $id;

    protected $_config;

    protected $_uploader;




    /**
     * 构造器
     * 
     * @param int  $id   字符串 ID, 用户获取上传配置
     * @param array  $config 
     */
    public function __construct( $id, $config = [])
    {
        $this->id = strtr($id, ['/' => '-']);
        $this->_config = new Config(['id' => $id]);
        parent::__construct($config);
    }



    /**
     * 获取对应 id 的配置选项
     * 
     * @return Config
     */
    public function getConfig()
    {
        return $this->_config;
    }


    
    /**
     * 上传文件。
     * 
     * @param  string $name  文件上传 input 的 name 参数
     * @return string 文件相对路径。
     */
    public function upload( $name = 'file' )
    {
        $options = $this->getConfig()->getUploaderOptions();
        $uploader = new StorageUploader($name, $options);
        if(!$uploader->validate()) {
            $errors = $uploader->getErrors();
            $message = $errors['file'];
            throw new UploadUserException($message);
        }
        $filename = $uploader->upload();
        $this->_uploader = $uploader;
        return $uploader;
    }



    /**
     * 获取上传后的相对文件名，包括path
     * 
     * @return string
     */
    public function getUploadedFilename()
    {
        return $this->_uploader->getFilePath();
    }



    /**
     * 获取上传的文件名，不包含 path
     * 
     * @return string
     */
    public function getFilename()
    {
        return $this->_uploader->getFilename();
    }




    /**
     * 获取上传的信息。
     * 
     * @return string
     */
    public function getUploadInfo()
    {
        return $this->_uploader->getUploadInfo();
    }



    /**
     * 是否为完整上传或者分片上传完成。
     * 
     * @return boolean
     */
    public function done()
    {
        return $this->_uploader->done();
    }



    /**
     * 获取上传的存储
     * 
     * @return Storage
     */
    public function getStorage()
    {
        return $this->_uploader->getStorage();
    }




    /**
     * 获取上传的文件的 url
     * 
     * @param  int  $width  宽度
     * @param  int  $height 高度
     * @return string
     */
    public function getUrl($width = null, $height = null)
    {
        return $this->getStorage()->getUrl($this->getUploadedFilename(), $width, $height);
    }



}