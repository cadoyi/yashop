<?php

namespace frontend\components;

use Yii;

/**
 * 前端的 view 组件
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class View extends \cando\web\View
{


    /**
     * 获取网站标题
     * 
     * @return string
     */
    public function getTitle()
    {
        if(is_null($this->title)) {
            $this->title = Yii::$app->config->get('web/header/title', 'yashop');
        }
        return $this->title;
    }


    /**
     * 注册 seo meta tags
     */
    public function registerSeoMetaTags()
    {
        $this->registerMetaTag([
            'name'   => 'keywords',
            'value'  =>  Yii::$app->config->get('web/header/keywords'),    
        ]);
        $this->registerMetaTag([
            'name' => 'description',
            'value' => Yii::$app->config->get('web/header/description'),
        ]);
    }

}