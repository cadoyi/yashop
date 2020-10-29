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
    public function ajax()
    {
         return [
             'save',
         ];
    }



    /**
     * @inheritdoc
     */
    public function verbs()
    {
        return [
            'save' => ['post'],
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
        $config = Yii::$app->config->system();
        $section = $config->activeSection($section);
        if(!$section) {
            return $this->notFound();
        }
        return $this->render('edit', ['section' => $section]);
    }




    /**
     * 保存。
     * 
     * @param  string $section section 名称
     * @return json
     */
    public function actionSave( $section )
    {
        $config = Yii::$app->config->system();
        $section = $config->activeSection($section);
        if(!$section) {
            return $this->error('页面已经过期！请刷新重试！');
        }
        try {
            if($section->load($this->request->post()) && $section->save()) {
                return $this->success();
            }
            return $this->error('验证出错', $section->getErrors()); 
        } catch(\Exception | \Throwable $e) {
            return $this->error($e->getMessage());
        }

    }
}