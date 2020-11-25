<?php

namespace core\models;

use Yii;
use yii\base\Component;


/**
 * 动态表单,支持组合验证和保存.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class DynamicForm extends Component
{

    protected $_forms = [];


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->initForms();
    }




    /**
     * 初始化对应的表单.
     * 
     * @return array
     */
    public function initForms()
    {
        
    }





    /**
     * 加载 post 数据.
     * 
     * @param  array  $data 请求数据
     * @return boolean
     */
    public function load( $data )
    {
        if(empty($data)) return false;
        $result = true;
        foreach($this->_forms as $form) {
            if(!$form->load($data)) {
                $result = false;
            }
        }
        return $result;
    }



    /**
     * 验证
     * 
     * @return boolean
     */
    public function validate()
    {
        $result = true;
        foreach($this->_forms as $form) {
            if(!$form->validate()) {
                $result = false;
            }
        }
        return $result;
    }



    /**
     * {@inheritdoc}
     */
    public function __get($name)
    {
        if ($this->hasAttribute($name)) {
            return $this->_forms[$name];
        }
        return parent::__get($name);
    }



    /**
     * getter 包装
     * 
     * @param  string $name 
     * @return mixed
     */
    public function get($name)
    {
        return $this->__get($name);
    }



    /**
     * {@inheritdoc}
     */
    public function __set($name, $value)
    {
        if ($this->hasAttribute($name)) {
            $this->_forms[$name] = $value;
        } else {
            parent::__set($name, $value);
        }
    }



    /**
     * setter 包装
     * 
     * @param string $name  
     * @param mixed $value 
     */
    public function set($name, $value)
    {
        $this->__set($name, $value);
    }



    /**
     *  isset 包装
     * 
     * @param  string  $name 
     * @return boolean
     */
    public function has($name)
    {
        return $this->__isset($name);
    }


    /**
     * {@inheritdoc}
     */
    public function __isset($name)
    {
        if ($this->hasAttribute($name)) {
            return isset($this->_forms[$name]);
        }

        return parent::__isset($name);
    }



    /**
     * unset 包装
     * 
     * @param  string $name
     * @return null
     */
    public function remove($name)
    {
        return $this->__unset($name);
    }

    /**
     * {@inheritdoc}
     */
    public function __unset($name)
    {
        if ($this->hasAttribute($name)) {
            unset($this->_forms[$name]);
        } else {
            parent::__unset($name);
        }
    }



    /**
     * {@inheritdoc}
     */
    public function canGetProperty($name, $checkVars = true, $checkBehaviors = true)
    {
        return parent::canGetProperty($name, $checkVars, $checkBehaviors) || $this->hasAttribute($name);
    }


    /**
     * {@inheritdoc}
     */
    public function canSetProperty($name, $checkVars = true, $checkBehaviors = true)
    {
        return parent::canSetProperty($name, $checkVars, $checkBehaviors) || $this->hasAttribute($name);
    }






    /**
     * 是否有对应的属性.
     *
     * @param  string $name 属性名.
     */
    public function hasAttribute($name)
    {
        return true;
    }




    public function attributes()
    {
        return array_keys($this->_forms);
    }



}