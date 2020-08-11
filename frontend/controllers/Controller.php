<?php

namespace frontend\controllers;

use Yii;

/**
 * 前端控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Controller extends \cando\web\Controller
{




    /**
     * 获取当前用户
     * 
     * @return IdentityInterface
     */
    public function getIdentity()
    {
        return $this->user->identity;
    }




    /**
     * 获取 user 组件
     * 
     * @return yii\web\User
     */
    public function getUser()
    {
        return Yii::$app->user;
    }



    /**
     * 成功的消息
     * 
     * @param  string $message 消息
     * @param  array  $params  消息参数
     * @return $this
     */
    protected function _success($message, $params = [])
    {
        $message = Yii::t('app', $message, $params);
        Yii::$app->session->setFlash('success', $message);
        return $this;
    }



    /**
     *  错误消息
     * 
     * @param  string $message 消息内容
     * @param  array  $params  消息参数
     * @return $this
     */
    protected function _error($message, $params = [])
    {
        $message = Yii::t('app', $message, $params);
        Yii::$app->session->setFlash('error', $message);
        return $this;
    }


    
    
} 