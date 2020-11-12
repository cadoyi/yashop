<?php

namespace issue\backend\vms\menu;

use Yii;
use cando\web\ViewModel;

/**
 * 设置 json 加载数据.
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Load extends ViewModel
{

    
    public $menus;


    /**
     * 获取 json 数组.
     * 
     * @return array
     */
    public function toArray()
    {
        $data = [];
        foreach($this->menus as $menu) {
            $data[] = $this->getJsonData($menu);
        }            
        return $data;
    }



    /**
     * 获取一个分类的 json 数据.
     * 
     * @param  Menu $menu
     * @return array
     */
    public function getJsonData( $menu )
    {
        $data = $menu->toArray();
        $data['text'] = $menu->title;
        $data['children'] = $menu->hasChild();
        return $data;
    }





}