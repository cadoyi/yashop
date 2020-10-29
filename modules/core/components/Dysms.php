<?php

namespace core\components;

use Yii;
use yii\base\Component;


/**
 * 发送手机短信。
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class Dysms extends Component
{


    public function getSignName()
    {
        return '';
    }


    public function getTemplateCode()
    {
        return '';
    }


    /**
     * 发送验证码。
     * 
     * @param  string $code     验证码
     * @param  string $phone    手机号
     * @param  array $params    其他参数
     * @return boolean
     */
    public function sendCode($code, $phone, $params = [])
    {
        if(!isset($params['SignName'])) {
            $params['SignName'] = $this->getSignName();
        }
        if(!isset($params['TemplateCode'])) {
             $params['TemplateCode'] = $this->getTemplateCode();
        }
        $params['PhoneNumbers'] = $phone;
        $param = $params['TemplateParam'] ?? [];
        $param['code'] = $code;
        $params['TemplateParam'] = json_encode($param);
        
        
    }

}