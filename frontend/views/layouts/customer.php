<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use front\widgets\Menu as CodeMenu;
use frontend\assets\basic\customer\CenterAsset;

CenterAsset::register($this);
?>
<?php 
/**
 * @var  $this yii\web\View
 * 
 */
$customer = Yii::$app->user->identity;
?>
<?php $this->beginContent('@frontend/views/layouts/base.php') ?>
<header class="customer-dashboard-header">
           <div class="menu-bar d-flex align-items-center">
           <div class="logo-wrap mr-auto">
               <a href="<?= Yii::$app->homeUrl ?>">
                   <img src="<?= $this->getAssetUrl('img/yashop.png') ?>" />
               </a>
           </div>
         <?= CodeMenu::widget([
              'code' => 'header',
              'options' => [
                  'class' => 'nav',
              ],
              'itemOptions' => ['class' => 'nav-item'],
              'linkTemplate' => '<a class="nav-link" href="{url}">{label}</a>',
        ])?>
           <?= $this->render('main/search') ?>
       </div>
</header>
<main class="page-content container-fluid p-0">
    <div class="page-content-wrapper">
        <div class="sidebar">
            <div class="sidebar-title">
                账户管理
            </div>
            <div class="sidebar-menus">
              <?= Menu::widget([
                  'items' => [
                      [
                          'label' => '基本信息',
                          'url'   => ['/customer/center/dashboard'],
                      ],
                      [
                          'label'   => '修改密码',
                          'url'     => ['/customer/center/password'],
                          'visible' => $customer->hasPasswordAccount(),
                      ],
                      [
                          'label' => '账号绑定',
                          'url'   => ['/customer/center/bind'],
                      ],
                      [
                          'label' => '地址管理',
                          'url'   => ['/customer/address/index'],
                      ],
                      [
                          'label' => '收藏中心',
                          'url'   => ['/wishlist/wishlist/index'],
                      ],
                      [
                           'label' => '我的订单',
                           'url'   => ['/customer/order/index'],
                      ],
                      [
                          'label' => '退出登录',
                          'url'   => ['/customer/account/logout'],
                          'template' => '<a data-method="post" date-confirm="确定要注销吗? " href="{url}">{label}</a>',
                      ],                   
                  ],
              ])?>
            </div>
        </div>
        <div class="toggle-sidebar"></div>
        <div class="content">
            <div class="content-title d-flex border-bottom">
              <div id="menu-card-title"></div>
              <?php if(isset($this->blocks['menus'])): ?>
                  <?= $this->blocks['menus'] ?>
              <?php endif; ?>
            </div>
            <div class="container-fluid">
                <?= $content ?>
            </div>
        </div>
    </div>
</main>
<footer class="footer">
    
</footer>
<?php $this->beginScript() ?>
<script>
   var li = $('.sidebar-menus li.active');
   var text = li.children('a').text();
   $('#menu-card-title').text(text);
</script>
<?php $this->endScript() ?>
<?php $this->endContent() ?>