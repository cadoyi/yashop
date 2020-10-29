<?php 
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="layui-header">
    <a class="layui-logo" href="<?= Yii::$app->homeUrl ?>">
         <?= Html::encode(Yii::$app->name) ?>      
    </a>

    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item"><a href="">控制台</a></li>
      <li class="layui-nav-item"><a href="">商品管理</a></li>
      <li class="layui-nav-item"><a href="">用户</a></li>
      <li class="layui-nav-item">
        <a href="javascript:;">其它系统</a>
        <dl class="layui-nav-child">
          <dd><a href="">邮件管理</a></dd>
          <dd><a href="">消息管理</a></dd>
          <dd><a href="">授权管理</a></dd>
        </dl>
      </li>
    </ul>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
          贤心
        </a>
        <dl class="layui-nav-child">
          <dd><a href="">基本资料</a></dd>
          <dd><a href="">安全设置</a></dd>
          <dd lay-unselect>
              <a href="<?= Url::to(['/admin/account/logout'])?>" 
                 data-method="post"
                 data-confirm="确定要退出登录吗？ "
                 class="logout"
                 style="color:#fd5151;"
              >
                  退出登录
              </a>
          </dd>
        </dl>
      </li>
    </ul>
</div>