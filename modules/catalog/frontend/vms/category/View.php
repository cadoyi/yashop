<?php

namespace catalog\frontend\vms\category;

use Yii;
use cando\web\ViewModel;
use catalog\models\Category;

/**
 * 查看分类
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class View extends ViewModel
{


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->addBreadcrumbs();
    }




    /**
     * 增加面包屑导航
     */
    public function addBreadcrumbs()
    {
        $category = $this->category;
        $path = $category->path;
        $ids = explode('/', $path);
        $count = count($ids);
        switch($count) {
            case 1:
               break;
            case 2:
               $parent = $category->parent;
               $this->getView()->addBreadcrumb($parent->title, ['view', 'id' => $parent->id]);
               break;
            default:
                array_pop($ids);
                $categories = Category::find()
                   ->select(['title'])
                   ->indexBy('id')
                   ->orderBy(['path' => SORT_ASC])
                   ->andWhere(['in', 'id', $ids])
                   ->tableCache()
                   ->column();
                foreach($categories as $id => $title) {
                    $this->getView()->addBreadcrumb($title, ['view', 'id' => $id]);
                }
            break;
        }
    }


    

}