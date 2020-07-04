<?php

namespace modules\core\backend\vms\config;

use Yii;

/**
 * 编辑配置
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Edit extends \cando\web\ViewModel
{


    /**
     * 获取 section
     * 
     * @return cando\config\system\Section
     */
    public function getSection()
    {
        return $this->model->section;
    }


    /**
     * 获取 fieldsets
     * 
     * @return array
     */
    public function getFieldsets()
    {
        return $this->section->fieldsets;
    }

}