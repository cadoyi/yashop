<?php

namespace catalogsearch\frontend\controllers;

use Yii;
use frontend\controllers\Controller;
use catalogsearch\models\filters\ProductFilter;

/**
 * 搜索产品结果
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductController extends Controller
{

    /**
     * 搜索结果。
     * 
     * @return string
     */
    public function actionResult( $q )
    {
        $filterModel = new ProductFilter();
        $dataProvider = $filterModel->search(['q' => $q], '');
        return $this->render('result', [
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}