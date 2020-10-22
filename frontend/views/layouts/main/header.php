<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * main layout header 
 *
 * @var  $this yii\web\View
 * 
 */
?>
<header class="header">
    <nav class="navbar navbar-light navbar-expand">
      <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">Yashop</a>
      <div class="collapse navbar-collapse link-white">
        <ul class="navbar-nav mr-auto">
            <?php if(Yii::$app->user->isGuest): ?>
            <li class="nav-item">
              <a class="nav-link login" 
                 href="<?= Url::to(['/customer/account/login'])?>">登录</a>
            </li>
            <li class="nav-item">
              <a class="nav-link register" href="<?= Url::to(['/customer/account/register'])?>">注册</a>
            </li>
            <?php else: ?>
              <li class="nav-item dropdown login-menus">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  我的用户名
                  </a>
                <div class="dropdown-menu  link-dark" aria-labelledby="navbarDropdown">
                  <div class="dropdown-item d-flex flex-nowrap">
                      <div class="" style="width: 60px;">
                           <img class="rounded-circle" width="60" height="60" src="<?= $this->getAssetUrl('img/ph.svg') ?>" />
                      </div>
                      <div class="flex-grow-1 d-flex justify-content-end align-self-start">
                          <a class="logout-link" 
                             href="<?= Url::to(['/customer/account/logout'])?>"
                             data-method="post"
                             data-confirm="确定要退出登录吗 ?"
                          >
                             退出
                          </a>
                      </div>
                  </div>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">帐号管理</a>
                  <a class="dropdown-item" href="#">我的订单</a>
                </div>
              </li>
            <?php endif; ?>
            <li class="nav-item">
              <a class="nav-link appd" href="#">APP 下载</a>
            </li>
        </ul>
        <ul class="navbar-nav navbar-nav2">
            <li class="nav-item active">
              <a class="nav-link" href="#">购物车</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">我的收藏</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">联系客服</a>
            </li>          
            <li class="nav-item">
              <a class="nav-link" href="#">免费开店</a>
            </li>
        </ul>
      </div>
    </nav>
</header>