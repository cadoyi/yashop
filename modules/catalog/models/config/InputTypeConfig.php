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

}