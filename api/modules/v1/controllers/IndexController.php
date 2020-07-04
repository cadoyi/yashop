<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;

/**
 * default controller
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class IndexController extends Controller
{



    /**
     * v1 controller
     * 
     * @return array
     */
    public function actionIndex()
    {
        return ['ok' => 'true'];
    }


}