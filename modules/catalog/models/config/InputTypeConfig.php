<?php

namespace catalog\models\config;

use Yii;
use cando\config\loaders\ConfigData;


/**
 * 输入类型配置.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class InputTypeConfig extends ConfigData
{



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
     * 类型别名
     * 
     * @return string
     */
    public function getType()
    {
        return $this->name;
    }




    /**
     * 获取 label
     * 
     * @return string
     */
    public function getLabel()
    {
        $label = $this->get('label', $this->name);
        return $this->t($label);
    }




    /**
     * 是否需要 items
     * 
     * @return boolean
     */
    public function requireItems()
    {
        return $this->get('values', false);
    }



    /**
     * 提示信息.
     * 
     * @return string
     */
    public function getHint()
    {
        $hint = $this->get('hint', '');
        return $hint;
    }



    /**
     * 获取渲染器.
     * 
     * @return InputTypeRender
     */
    public function getRender()
    {
        $options = $this->get('render', ['class' => InputTypeRender::class]);
        if(is_string($options)) {
            $options = ['class' => $options];
        }
        $options['config'] = $this;
        $render = Yii::createObject($options);
        return $render;
    }




    /**
     * 渲染的 input 选项.
     * 
     * @return array
     */
    public function getRenderInputOptions()
    {
        return $this->get('renderInputOptions', []);
    }




}