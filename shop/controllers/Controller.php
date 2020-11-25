<?php

namespace shop\controllers;

use Yii;
use yii\base\Model;
use store\models\Store;

/**
 * 后台控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Controller extends \cando\web\Controller
{

    protected $_currentStore;

    /**
     * @inheritdoc
     */
    /*
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
    } */




    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->on(static::EVENT_BEFORE_ACTION, function( $event ) {
            $store = $this->store;
            Yii::$app->set('currentStore', $store);
        });
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



    /**
     * 获取店铺。
     * 
     * @return string
     */
    public function getStore()
    {
        if(!$this->_currentStore) {
            $this->_currentStore = Store::find()->limit(1)->one();
        }
        return $this->_currentStore;
    }


    /**
     * @inheritdoc
     * @param  [type]  $id    [description]
     * @param  [type]  $class [description]
     * @param  boolean $throw [description]
     * @param  [type]  $field [description]
     * @return [type]         [description]
     */
    public function findModel($id, $class, $throw = true, $field = null)
    {
        if(is_numeric($id) || is_string($id)) {
            if(!is_null($field)) {
                $where = [$field => $id];
            } else {
                $primaryKey = $class::primaryKey();
                $field = $primaryKey[0];
                $where = [$field => $id]; 
            }
            $instance = $class::instance();
            if($instance->hasAttribute('store_id')) {
                $where['store_id'] = $this->store->id;
            }

            $model = $class::findOne($where);
            if($model instanceof $class) {
                if($model->hasMethod('setStore')) {
                    $model->setStore($this->store);
                }
                return $model;
            }
        }
        return $throw ? $this->notFound() : null;
    }

}