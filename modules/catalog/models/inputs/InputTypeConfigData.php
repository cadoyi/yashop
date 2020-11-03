<?php

namespace catalog\models\inputs;

use Yii;
use yii\helpers\Json;
use cando\config\loaders\ConfigData;
use catalog\models\inputs\renders\Render;

/**
 * input_type ConfigData
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class InputTypeConfigData extends ConfigData
{

    protected $_render;


    /**
     * 获取 label
     * 
     * @return string
     */
    public function getLabel()
    {
        return $this->get('label');
    }


    
    /**
     * 获取名称.
     * 
     * @return string
     */
    public function getName()
    {
        return $this->get('name');
    }



  
    /**
     * 别名
     * 
     * @return string
     */
    public function getType()
    {
        return $this->getName();
    }



    /**
     * 获取 type attribute
     * 
     * @return TypeAttribute 实例.
     */
    public function getTypeAttribute()
    {
        return $this->get('typeAttribute');
    }



    /**
     * 获取渲染器
     * 
     * @return string|array
     */
    public function getRender()
    {
        if(!$this->_render) {
            $renderConfig = $this->get('render', Render::class);
            if(is_string($renderConfig)) {
                $renderConfig = ['class' => $renderConfig];
            }
            $renderConfig['typeConfig'] = $this;
            $this->_render = Yii::createObject($renderConfig);          
        }
        return $this->_render;
    }




    /**
     * 获取选项.
     * 
     * @return array
     */
    public function getOptions()
    {
        return $this->get('options', []);
    }



    /**
     * 获取多选框或者 checkboxList 等输入框的 items 配置
     * 
     * @return array
     */
    public function getItems()
    {
        $values = $this->typeAttribute->values;
        if(is_string($values)) {
            $values = trim($values);
            if(!empty($values)) {
                return Json::decode($values);
            }
        }
        return [];
    }



}