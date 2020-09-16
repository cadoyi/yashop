<?php

namespace payment\models\alipay\mobile;

use Yii;
use payment\models\alipay\common\PayReturn as BasePayReturn;

/**
 * pay 之后调用 return_url, 这里处理验证并记录返回.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class PayReturn extends BasePayReturn
{

}

