<?php

namespace modules\admin\backend\vms;

use Yii;
use cando\web\ViewModel;

/**
 * 登录视图
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
class LoginView extends ViewModel
{



    /**
     * 获取 captcha action 的 URL
     * 
     * @return string
     */
    public function getCaptchaAction()
    {
        return 'admin/account/captcha';
    }



    /**
     * 获取输入用户名的模板
     * 
     * @return string
     */
    public function getUsernameTemplate()
    {
        return <<<TEMPLATE
<div class="input-group mb-3">
  <div class="input-group-prepend">
      <div class="input-group-text">
          <i class="fa fa-fw fa-user"></i>
      </div>
  </div>
  {input}
</div>
{hint}
{error}        
TEMPLATE;
    }


    public function getPasswordTemplate()
    {
        return <<<TEMPLATE
<div class="input-group mb-3">
  <div class="input-group-prepend">
      <div class="input-group-text">
          <i class="fa fa-fw fa-lock"></i>
      </div>
  </div>
  {input}
</div>
{hint}
{error}
TEMPLATE;
    }


    /**
     * 验证码模板
     * 
     * @return string
     */
    public function getCaptchaTemplate()
    {
        return <<<TEMPLATE
<div class="input-group mb-3 input-group-captcha">
  <div class="input-group-prepend">
      <div class="input-group-text">
          <i class="fa fa-fw fa-image"></i>
      </div>
  </div>
  {input}
  {image}
</div>
TEMPLATE;
    }


}