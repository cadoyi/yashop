<?php

namespace catalog\models\inputs;

use Yii;

/**
 * 读取配置数据.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ConfigData extends \cando\config\loaders\ConfigData
{

    /**
     * 获取配置的所有类型
     *
     * @author  zhangyang <zhangyangcado@qq.com>
     */
    public function getTypes()
    {
        return $this->_data ?? [];
    }





}