<?php

namespace catalog\backend\controllers;

use Yii;
use backend\controllers\Controller;
use catalog\backend\vms\category\Load;
use catalog\backend\vms\category\Index;
use catalog\backend\vms\category\Edit;
use catalog\models\Category;
use catalog\models\filters\CategoryFilter;

/**
 * 产品分类控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class CategoryController extends Controller
{



    /**
     * @inheritdoc
     */
    public function verbs()
    {
         return [
             'load' => ['post', 'get'],
             'create' => ['post'],
             'update' => ['post'],
             'sort'   => ['post'],
             'delete' => ['post'],
         ];
    }



    /**
     * @inheritdoc
     */
    public function ajax()
    {
        return ['load', 'create', 'update', 'sort', 'delete'];
    }


    
    /**
     * @inheritdoc
     */
    public function viewModels()
    {
        return [
            'index'  => Index::class,
            'create' => Edit::class,
            'update' => Edit::class,
        ];
    }




    /**
     * 列出分类.
     */
    public function actionIndex()
    {
        return $this->render('index');
    }



    /**
     *  ajax 加载
     *  
     * @param  int  $id  
     * @return array
     */
    public function actionLoad( $id )
    {
        if($id === '#') {
            $categories = Category::find()
                ->andWhere(['parent_id' => 0])
                ->orderBy(['sort_order' => SORT_ASC ])
                ->all();
        } else {
            $category = $this->findModel($id, Category::class, false);
            if($category === false) {
                $categories = [];
            } else {
                $categories = $category->childs; 
            }
        }
        $model = new Load([ 'categories' => $categories ]);
        return $this->asJson($model);
    }




    /**
     * 新增分类.
     */
    public function actionCreate()
    {
        $pid = $this->request->post('parent');
        if($pid === '#') {
            $parent = null;
        } else {
            $parent = $this->findModel($pid, Category::class);
        }
        $category  = new Category([
           'parent_id' => $parent ?  $parent->id : null,
           'title'     => '新分类',
        ]);
        if($category->save()) {
            $load = new Load();
            $data = $load -> getJsonData($category);
            return $this->success($data);
        } else {
            return $this->error($category);
        }
    }


    /**
     * 更新分类.主要是用于重命名。
     * 
     * @param  int  $id  分类 ID
     */
    public function actionUpdate()
    {
        $id = $this->request->post('id');
        $title = $this->request->post('title');
        $category = $id ? $this->findModel($id, Category::class, false) : null;
        if(!$category) {
            return $this->error('分类已经不存在');
        }
        $category->title = $title;
        $category->save();
        return $this->success();
    }



    /**
     * 分类排序。
     * 
     * @return json
     */
    public function actionSort()
    {
        $ids = $this->request->post('ids');
        $categories = Category::find()
            ->andWhere(['id' => $ids])
            ->indexBy('id')
            ->all();
        $trans = Category::getDb()->beginTransaction();
        try {
            foreach($ids as $k => $id) {
                $category = $categories[$id];
                $category->sort_order = $k;
                $category->save();
            }
            $trans->commit();
            
        } catch(\Exception | \Throwable $e) {
            $trans->rollBack();
            return $this->error($e);
        }
        return $this->success();
    }



    /**
     * 删除分类.
     * 
     * @param  int  $id   分类 ID
     */
    public function actionDelete()
    {
        $id = $this->request->post('id');
        $model = $id ? $this->findModel($id, Category::class, false) : false;
        if(!$model) {
            return $this->error('分类不存在');
        }

        if($model->hasChild()) {
            return $this->error('当前分类有子分类， 因此不能被删除');
        }
        $model->virtualDelete();
        return $this->success();
    }


}