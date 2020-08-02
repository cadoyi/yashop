<?php

namespace catalog\models\inputs;

use Yii;
use yii\base\BaseObject;
use catalog\models\inputs\renders\Render;


class TypeConfig extends BaseObject
{

    protected $_data;

    public $parent;

    public $typeAttribute;
    

    /**
     * @inheritdoc
     */
    public function __construct($data, $config = [])
    {
        $this->_data = $data;
        parent::__construct($config);
    }


     
    /**
     * 获取 render 配置。
     * 
     * @return Render
     */
    public function getRender()
    {
        if(isset($this->_data['render'])) {
            $config = $this->_data['render'];
        } else {
            $config = Render::class;
        }
        if(is_string($config)) {
            $config = ['class' => $config];
        }
        $config['typeConfig'] = $this;
        return Yii::createObject($config);
    }



    /**
     * 获取渲染的类型。
     * 
     * @return string
     */
    public function getType()
    {
        return $this->_data['type'];
    }



    /**
     * 获取选项。
     * 
     * @return array
     */
    public function getOptions()
    {
        if(isset($this->_data['options'])) {
            return $this->_data['options'];
        }
        return [];
    }



    /**
     * 获取多选框或者 checkboxList 等输入框的 items 配置
     * 
     * @return array
     */
    public function getItems()
    {
        $values = $this->typeAttribute->values;
        if(is_null($values)) {
            $values = [];
        } else {
            $values = explode("\r\n", $values);
            $_values = [];
            foreach($values as $value) {
                if(trim($value) === '') {
                    continue;
                }
               $_values[$value] = $value;
            }
            $values = $_values;
        }
        return $values;
    }

}