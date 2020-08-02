<?php

namespace catalog\backend\controllers;

use Yii;
use backend\controllers\Controller;
use catalog\models\Type;
use catalog\models\TypeAttribute;
use catalog\models\filters\TypeAttributeFilter;


/**
 * 产品类型属性控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class TypeAttributeController extends Controller
{


    /**
     * 列出某个产品类型的属性.
     */
    public function actionIndex($type_id)
    {
        $type = $this->findModel($type_id, Type::class);
        $filterModel = new TypeAttributeFilter(['type' => $type]);
        $dataProvider = $filterModel->search($this->request->get());

        return $this->render('index', [
            'type'         => $type,
            'filterModel'  => $filterModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * 新建产品类型属性.
     * 
     * @param  int  $type_id  产品类型 ID
     */
    public function actionCreate( $type_id )
    {
        $type = $this->findModel($type_id, Type::class);

        $model = new TypeAttribute(['type_id' => $type->id ]);
        $model->insertMode();

        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('Product type attribute saved');
            return $this->redirect(['index', 'type_id' => $type->id ]);
        }
        return $this->render('edit', [
            'type'  => $type,
            'model' => $model,
        ]);
    }



    /**
     * 更新产品类型
     * 
     * @param  int  $type_id  产品类型 ID
     * @param  int  $id  属性 ID
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id, TypeAttribute::class);
        $type = $model->type;
        $model->updateMode();

        if($model->load($this->request->post()) && $model->save()) {
            $this->_success('Product type attribute saved');
            return $this->redirect(['index', 'type_id' => $type->id ]);
        }
        return $this->render('edit', [
            'type'  => $type,
            'model' => $model,
        ]);

    }




    /**
     * 删除产品类型.
     * 
     * @param  int    $type_id  产品类型 ID
     * @param  int     $id      属性 ID
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id, TypeAttribute::class);
        $type = $model->type;
        $model->delete();
        $this->_success('Product type attribute deleted');
        return $this->redirect(['index', 'type_id' => $type->id ]);
    }


}