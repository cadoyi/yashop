<?php

namespace catalog\frontend\controllers;

use Yii;
use frontend\controllers\Controller;
use catalog\models\Category;
use catalog\models\filters\CategoryProductFilter;
use catalog\frontend\vms\category\View;

/**
 * 分类控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CategoryController extends Controller
{


    /**
     * @inheritdoc
     */
    public function viewModels()
    {
        return [
            'view' => View::class,
        ];
    }


    /**
     * 查看分类下的所有产品,包含子分类
     * 
     * @param  int  $id  分类 ID
     * @return string
     */
    public function actionView( $id )
    {
        $category = $this->findModel($id, Category::class);
        $filterModel = new CategoryProductFilter(['category' => $category]);
        $dataProvider = $filterModel->search([]);
        return $this->render('view', [
            'category'     => $category,
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);

    }

}