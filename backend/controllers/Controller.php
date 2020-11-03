<?php

namespace backend\controllers;

use Yii;
use yii\base\Model;

/**
 * 后台控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Controller extends \cando\web\Controller
{

    /**
     * @inheritdoc
     */
    public function access()
    {
        return [
           'rules' => [
                [
                    'roles' => ['?'],
                    'allow' => false,
                ],
                [],
           ],
        ];
    }



    /**
     * 记录日志.
     * 
     * @param  string $description 描述文本
     * @param  array  $params      替换参数
     * @return boolean
     */
    public function log($description, $params = [])
    {
        return $this->identity->log($description, $params);
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
    protected function error( $message, $code = 1, $data = [])
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
            'error'   => $code,
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



    /**
     * @inheritdoc
     */
    public function render($view, $params = [])
    {
        if($this->request->isAjax && $this->request->get('_pjax')) {
            return $this->renderAjax($view, $params);
        }
        return parent::render($view, $params);
    }



    /**
     * serialize dataProvider
     * 
     * @param  [type] $dataProvider [description]
     * @return [type]               [description]
     */
    public function serialize($dataProvider)
    {
        $models = $dataProvider->getModels();
        $data = [];
        foreach($models as $model) {
            $data[] = $model->toArray();
        }
        $jsonData = [
           'code'  => 0,
           'msg'   => "",
           'count' => $dataProvider->getTotalCount(),
           'data'  => $data,
        ];
        return $this->asJson($jsonData);
    }

}