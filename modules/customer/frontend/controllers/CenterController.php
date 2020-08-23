<?php

namespace customer\frontend\controllers;

use Yii;
use frontend\controllers\Controller;
use customer\frontend\models\center\PasswordForm;

/**
 * 客户中心控制器
 *
 * @author  zhangyang <zhangyangcado@qq.co>
 */
class CenterController extends Controller
{

    public $layout = 'customer';


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
                    'allow' => true,
                ],
            ],
        ];
    }

    /**
     * 客户中心面板
     * 
     * @return string
     */
    public function actionDashboard()
    {
        $customer = $this->identity;
        if($customer->load($this->request->post()) && $customer->save()) {
            $this->_success('Customer saved');
            return $this->refresh();
        }

        return $this->render('dashboard', [
            'customer' => $customer,
        ]);
    }



    /**
     * 修改密码
     * 
     * @return string
     */
    public function actionPassword()
    {
        $model = new PasswordForm();
        if($model->load($this->request->post()) && $model->changePassword()) {
            $this->_success('Password changed');
            return $this->refresh();
        }
        return $this->render('password', [
            'model' => $model,
        ]);
    }



    /**
     * 绑定账户
     * 
     * @return string
     */
    public function actionBind()
    {
        return $this->render('bind');
    }


}