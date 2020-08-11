<?php


namespace catalog\frontend\controllers;

use Yii;
use frontend\controllers\Controller;
use catalog\models\Product;
use catalog\frontend\vms\product\View;

/**
 * 产品控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ProductController extends Controller
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
     * 查看产品
     * 
     * @param  string $id  产品 ID
     * @return string
     */
    public function actionView( $id )
    {
        $product = $this->findModel($id, Product::class, true, '_id');

        return $this->render('view', [
            'product' => $product,
        ]);
    }

}
