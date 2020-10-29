<?php

namespace core\backend\vms\config\renders;

use Yii;
use cando\config\system\renders\AbstractRender;

/**
 * 字段渲染器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class FieldRender extends AbstractRender
{

    public $viewPath = '@core/backend/views/config/fields/';


    /**
     * 渲染
     * 
     * @param  array  $params 相关的参数
     * @return string
     */
    public function render($params = [])
    {
        $field = $this->field;
        $type = $field->type;
        $viewPath = $this->viewPath . $type;
        $view = $params['view'] ?? Yii::$app->view;
        $params['field'] = $this->field;
        $params['render'] = $this;
        return $view->render($viewPath, $params);
    }

}