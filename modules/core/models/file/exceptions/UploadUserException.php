<?php

namespace core\models\file\exceptions;

use Yii;


/**
 * 上传异常信息用户可见
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class UploadUserException extends UploadException
{


    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'UploadUserException';
    }

    

}