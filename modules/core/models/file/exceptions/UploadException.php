<?php

namespace core\models\file\exceptions;

use Yii;
use yii\base\Exception;

/**
 * 上传异常处理。
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class UploadException extends Exception
{


    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'UploadException';
    }

    

}