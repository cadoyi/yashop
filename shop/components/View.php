<?php

namespace shop\components;

use Yii;

/**
 * 视图组件
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class View extends \cando\web\View
{


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->on(static::EVENT_BEFORE_RENDER, function($event) {
            $this->ensureSeo();
        });
    }



    /**
     * 确保 seo 
     * 
     * @return string
     */
    public function ensureSeo()
    {
        if(!$this->title) {
            $this->title = 'Yashp 管理后台';
        }
        
    }

}