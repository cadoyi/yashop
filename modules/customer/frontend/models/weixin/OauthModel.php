<?php

namespace customer\frontend\models\weixin;

use Yii;
use yii\di\Instance;
use yii\base\Component;
use yii\httpclient\Client;

/**
 * 微信 oauth 认证逻辑
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class OauthModel extends Component
{

    /**
     * 授权基本 URL
     */
    const BASE_AUTH_URL = 'https://open.weixin.qq.com/connect/qrconnect';

    
    /**
     * 获取 access token 的 URL
     */
    const BASE_TOKEN_URL = 'https://api.weixin.qq.com/sns/oauth2/access_token';


    /**
     * 获取用户信息的 URL
     */
    const BASE_USERINFO_URL = 'https://api.weixin.qq.com/sns/userinfo';


    /**
     * @var string  组件
     */
    public $httpclient = 'httpclient';



    /**
     * 获取系统配置
     * 
     * @return \cando\config\Config
     */
    public function getConfig()
    {
        return Yii::$app->config;
    }


    /**
     * 获取 app id
     * 
     * @return string
     */
    public function getAppId()
    {
        return $this->config->get('oauth/weixin/app_id');
    }



    /**
     * 获取 app secret
     * 
     * @return string
     */
    public function getAppSecret()
    {
        return $this->config->get('oauth/weixin/app_secret');
    }


    /**
     * 获取回调 URI
     * 
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->config->get('oauth/weixin/redirect_uri');
    }



    /**
     * 获取 httpclient 组件
     * 
     * @return yii\httpclient\Client
     */
    public function getClient()
    {
        if(!$this->httpclient instanceof Client) {
            $this->httpclient = Instance::ensure($this->httpclient, Client::class);
        }
        return $this->httpclient;
    }




    /**
     * 拼接并获取 oauth url
     * 
     * @return string
     */
    public function getAuthUrl($state = null)
    {
        $options = [
            'appid'         => $this->getAppId(),
            'redirect_uri'  => $this->getRedirectUri(),
            'response_type' => 'code',
            'scope'         => 'snsapi_login',
        ];
        if(!is_null($state)) {
            $options['state'] = $state;
        }
        return static::BASE_AUTH_URL . '?' . http_build_query($options);
    }



    /**
     * 通过授权码获取 access token
     *
     * 请求方法: GET
     *
     * 请求参数:
     *     [
     *         'appid'  => <client_id>,
     *         'secret' => <client_secret>,
     *         'code'   => <服务器返回的授权码>,
     *         'grant_type' => 'authorization_code',
     *     ]
     *
     * 正确返回示例:
     *     {
     *         'access_token': <ACCESS_TOKEN>,
     *         'expires_in': '过期时间',
     *         'refresh_token': <REFRESH_TOKEN>,
     *         'open_id': <OPEN_ID>,
     *         'scope': <scope>,
     *         'unionid': <UNIONID>,
     *     }
     *
     * 错误返回示例:
     *     {
     *         "errcode": 错误码,
     *         "errmsg": '错误消息'
     *     }
     * 
     * @param  string $code 授权码, 注意: 每个授权码只能使用一次.
     * @return yii\httpclient\Response
     */
    public function requestAccessToken( $code )
    {
        $params = [
            'appid'      => $this->getAppId(),
            'secret'     => $this->getAppSecret(),
            'grant_type' => 'authorization_code',
            'code'       => $code,
        ];
        $request = $this->getClient()->createRequest();
        $response = $request->setMethod('GET')
                ->setUrl(static::BASE_TOKEN_URL)
                ->setData($params)
                ->send();
        return $response;
    }



    /**
     * 获取用户的个人信息
     * 需要注意: 头像 URL 会失效,应该将头像 URL 保存下来
     *
     * 请求方法: GET
     * 
     * 请求参数:
     *   {
     *       "access_token": <ACCESS_TOKEN>,
     *       "openid": <OPEN_ID>,
     *       "lang": "zh_CN",        // 非必须参数
     *   }
     *
     * 正确返回:
     *   {
     *       "openid": <OPEN ID>,
     *       "unionid": <UNIONID>,
     *       "nickname": 昵称,
     *       "sex": <性别> 1: 男, 2: 女
     *       "province": "个人资料中的省份",
     *       "city": "个人资料中的城市",
     *       "country": "国家", 中国: CN
     *       "privilege": 特权信息, 使用 json 数组表示
     *       "headimgurl": 用户头像, 最后使用斜杠分隔最后部分,表示头像大小
     *   }
     *
     * 其中 headimgurl 最后表示头像大小, 可以自由调整这部分:
     * 比如:
     *    http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0
     *    最后位置的数值表示为:
     *       0: 640x640
     *       46: 46x46
     *       64: 64x64
     *       96: 96x96
     *       132: 132x132
     *       
     *
     * 错误返回:
     *   {
     *       "errcode": 40003,
     *       "errmsg": "invalid openid",
     *   }
     *   
     * 
     * @return yii\httpclient\Response
     */
    public function requestUserinfo($accessToken, $openid, $lang = 'zh_CN')
    {
        $params = [
            'access_token' => $accessToken,
            'openid'       => $openid,
            'lang'         => $lang,
        ];

        $request = $this->getClient()->createRequest();
        $response = $request->setUrl(static::BASE_USERINFO_URL)
            ->setMethod('GET')
            ->setData($params)
            ->send();

        return $response;
    }




    /**
     * 是否有错误信息.
     * 
     * @param  Response  $response 
     * @return boolean
     */
    public function isErrorResponse($response)
    {
        $result = !$response->isOk || (isset($response->data['errcode']) && $response->data['errcode'] != 0);

        return $result;
    }



 


}