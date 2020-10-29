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



    /**
     * 错误的 json 返回.
     * 
     * @param  string|Model $message 
     * @param  array  $data  附加的数据
     * @return string
     */
    protected function error( $message, $data = [])
    {
        if($message instanceof Model) {
            $messages = $message->getFirstErrors();
            $message = reset($messages);
        } elseif($message instanceof \Throwable) {
            $message = $message->getMessage();
        } elseif(is_array($message)) {
            $message = reset($message);
        }
        $_data = [
            'error'   => 1,
            'message' => $message,
            'data'    => $data,
        ];
        return $this->asJson($_data);
    }

    
    /**
     * 正确的 json 返回.
     * 
     * @param  array  $data 附加的数据
     * @return string
     */
    protected function success($data = [])
    {
        $_data = [
            'error'   => 0,
            'message' => 'OK',
            'data'    => $data,
        ];
        return $this->asJson($_data);
    }
 


    
    
} 