<?php

namespace front\backend\vms\nav;

use Yii;
use cando\web\ViewModel;

/**
 * 设置 json 加载数据.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Load extends ViewModel
{

    
    public $navs;





    /**
     * 获取 json 数组.
     * 
     * @return array
     */
    public function toArray()
    {
        $data = [];
        foreach($this->navs as $nav) {
            $data[] = $this->getJsonData($nav);
        }            
        return $data;
    }



    /**
     * 获取一个 nav 的 json 数据.
     * 
     * @param  Nav $nav
     * @return array
     */
    public function getJsonData( $nav )
    {
        $data = $nav->toArray();
        $data['text'] = $nav->title;
        $data['children'] = $nav->hasChild();
        return $data;
    }





}