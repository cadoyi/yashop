<?php

namespace core\widgets;

use Yii;

/**
 * 上传插件
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Uploader extends \cando\storage\widgets\Uploader
{

    public $uploadId;


    /**
     * @inheritdoc
     */
    public function init()
    {
        if(is_null($this->uploadUrl) && $this->uploadId) {
            $this->uploadUrl = ['/core/file/upload', 'id' => $this->uploadId];
        }
        parent::init();
        if(is_null($this->url)) {
            if($this->hasModel()) {
                $value = $this->model->{$this->attribute};
            } else {
                $value = $this->value;
            }
            if(Yii::$app->storage->has($value)) {
                $this->url = (string) Yii::$app->storage->getUrl($value);
            }
            
        }
    }
}