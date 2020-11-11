<?php

namespace catalog\backend\controllers;

use Yii;
use backend\controllers\Controller;
use catalog\models\CategoryAttribute;
use catalog\models\Category;
use catalog\models\filters\CategoryAttributeFilter;

/**
 * 分类属性控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CategoryAttributeController extends Controller
{


    /**
     * 属性列表.
     */
    public function actionIndex($cid)
    {
        $category = $this->findCategory($cid);
        $filterModel = new CategoryAttributeFilter([
            'category' => $category,
        ]);
        $dataProvider = $filterModel->search($this->request->get());

        return $this->render('index', [
            'category'     => $category,
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * 新建分类属性.
     * 
     * @param  int $cid  分类 ID
     */
    public function actionCreate($cid)
    {
        $category = $this->findCategory($cid);
        $attribute = new CategoryAttribute([
            'category' => $category,
        ]);
        $attribute->insertMode();

        if($attribute->load($this->request->post()) && $attribute->save()) {
            $this->_success('保存成功');
            return $this->redirect(['index', 'cid' => $category->id]);
        }

        return $this->render('edit', [
            'category' => $category,
            'model'    => $attribute,
        ]);
    }


    /**
     * 更新分类属性.
     * 
     * @param  int   $cid 分类 ID
     * @param  int   $id   属性 ID
     */
    public function actionUpdate($id)
    {

        $attribute = $this->findModel($id, CategoryAttribute::class);
        $category = $attribute->category;
        $attribute->updateMode();
        if($attribute->load($this->request->post()) && $attribute->save()) {
            $this->_success('保存成功');
            return $this->redirect(['index', 'cid' => $category->id]);
        }

        return $this->render('edit', [
            'category' => $category,
            'model'    => $attribute,
        ]);
        
    }


    /**
     * 删除分类属性.
     * 
     * @param  int    $cid  分类 ID
     * @param  int    $id   分类属性 ID
     */
    public function actionDelete($id)
    {
        $attribute = $this->findModel($id, CategoryAttribute::class, false);
        $category = $attribute->category;
        if($attribute) {
            $attribute->virtualDelete();
        }
        $this->_success('分类属性已删除');
        return $this->redirect(['index', 'cid' => $category->id]);
    }





    /**
     * 查找分类.
     * 
     * @param  int  $id    分类 ID
     * @param  boolean $throw 是否抛出异常
     * @return Category
     */
    public function findCategory($id, $throw = false)
    {
        return $this->findModel($id, Category::class, $throw);
    }



}