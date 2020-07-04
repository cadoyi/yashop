<?php

namespace modules\core\backend\controllers;

use Yii;
use backend\controllers\Controller;
use cando\config\models\SectionModel;
use modules\core\backend\vms\config\Edit;


/**
 * 系统配置控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class ConfigController extends Controller
{


    /**
     * @inheritdoc
     */
    public function access()
    {
        return [
           'rules' => [
               [
                   'roles' => ['?'],
                   'allow' => false,
               ],
               [
               ],
           ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function viewModels()
    {
        return [
           'edit' => [
               'class' => Edit::class,
           ],
        ];
    }


    /**
     * 编辑配置.
     * 
     * @param  string $scope  scope 值
     * @return string
     */
    public function actionEdit($scope = null)
    {
        $config = Yii::$app->config->getSystemConfig();
        $section = $config->activeSection($scope);
        if(!$section) {
            return $this->notFound();
        }
        $model = new SectionModel(['section' => $section]);
        if($model->load($this->request->post()) && $model->save()) {
            return $this->refresh();
        }
        return $this->render('edit', ['model' => $model]);
    }
}