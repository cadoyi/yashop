<?php

namespace core\backend\controllers;

use Yii;
use backend\controllers\Controller;
use cando\config\models\SectionModel;
use core\backend\vms\config\Edit;


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
    public function actionEdit($section = null)
    {
        $config = Yii::$app->config->getSystemConfig();
        $section = $config->activeSection($section);
        if(!$section) {
            return $this->notFound();
        }
        if($section->load($this->request->post()) && $section->save()) {
            $this->session->setFlash('success', Yii::t('app', 'Config saved'));
            return $this->refresh();
        }
        return $this->render('edit', ['section' => $section]);
    }
}