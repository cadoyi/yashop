<?php

namespace customer\frontend\controllers;

use Yii;
use frontend\controllers\Controller;
use customer\frontend\models\weixin\OauthModel;
use customer\models\types\Weixin;

/**
 * 微信账户控制器
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class WeixinController extends Controller
{



    /**
     * 登录
     */
    public function actionLogin()
    {
        $state = md5(Yii::$app->security->generateRandomString(32));
        $this->session->set('weixin_state', $state);
        $model = new OauthModel();
        return $this->redirect($model->getAuthUrl($state));
    }



    /**
     * 微信回调接口.
     * 
     * @param  string $state 验证信息
     * @param  string $code  授权码,如果用户拒绝授权,则它不会被返回
     * @return string
     */
    public function actionCallback($state, $code = null)
    {
        if(!$state || ($state !== $this->session->get('weixin_state'))) {
            return $this->notFound();
        }
        if(is_null($code)) {
            $this->_error('您拒绝了授权请求');
            return $this->redirect(['/customer/account/login']);
        }
        $model = new OauthModel();
        $response = $model->requestAccessToken($code);
        if($model->isErrorResponse($response)) {
            $this->_error($response->data['errmsg']);
            return $this->redirect(['/customer/account/login']);
        }
        $tokenData = $response->data;
        $unionid = isset($tokenData['unionid']) ? $tokenData['unionid'] : null;
        if($unionid) {
            $account = Weixin::findByUnionid($unionid);
            if($account) {
                $account->data = $tokenData;
                $account->save();
                $customer = $account->identity;
                $this->user->login($customer);
                return $this->goHome();
            }
        } 
        $userinfoResponse = $model->requestUserinfo($tokenData['access_token'], $tokenData['openid']);
        if($model->isErrorResponse($userinfoResponse)) {
            $this->_error($userinfoResponse->data['errmsg']);
            return $this->redirect(['/customer/account/login']);
        }

        $userinfo = $userinfoResponse->data;
        if(!$unionid) {
            $unionid = $userinfo['unionid'];
        }
        $account = new Weixin([
           'unionid' => $unionid,
           'data'  => array_merge($tokenData, ['unionid' => $unionid]),
        ]);
        $account->save();
        $customer = $account->identity;
        $customer->nickname = $userinfo['nickname'];
        $avatar = isset($userinfo['headimgurl']) ? $userinfo['headimgurl'] : null;
        if($avatar) {
            $pos = strrpos($avatar, '/');
            $avatar = substr($avatar, 0, $pos) . '/0';
            $url = $this->uploadAvatar($avatar);
        } else {
            $url = null;
        }
        $customer->avatar = $url;
        $customer->save();
        $this->user->login($customer);
        return $this->goHome();
    }




    /**
     * 存储 avatar 到本地, 并获取对应的 URL
     * 
     * @param  string $avatar 原始 avatar URL
     * @return string
     */
    public function uploadAvatar($avatar)
    {
        $storage = Yii::$app->storage;
        do {
            $filename = $storage->generateFilename();
            $path = 'customer/customer/avatar';
            $filepath = $storage->pathize($path, $filename);
        } while($storage->has($filepath));
        $in = fopen($avatar, 'rb');
        $storage->writeStream($filepath, $in);    
        return strtr($filepath, ['\\', '/']);
    }

}