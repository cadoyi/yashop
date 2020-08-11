<?php 
use yii\helpers\Html;
use yii\helpers\Url;

?>
<header class="page-head">
     <div class="title-bar d-flex justify-content-between">
         <div class="d-flex flex-nowrap">
             <a href="<?= Yii::$app->homeUrl ?>">
                <?= Yii::t('app', 'Welcome visite {name} shop', [
                   'name' => 'yashop',
                ])?>
             </a> 
             | 
             <?php if(Yii::$app->user->isGuest): ?>
                 <a href="<?= Url::to(['/customer/account/login']) ?>">
                     <i class="fa fa-sign-in"></i> <?= Yii::t('app', 'Login')?>
                 </a>
             <?php else: ?>
                <ul class="nav customer-nav">
                   <li class="nav-item dropdown">
                       <a class="nav-link dropdown-toggle" 
                          data-toggle="dropdown" 
                          href="#"
                       >
                          zhan**ang
                       </a>
                        <div class="dropdown-menu">
                             <div class="dropdown-item text-center border-bottom">
                                 嗨! &lt;<?= 'zhangyang' ?>&gt;
                             </div>
                             <a class="dropdown-item" href="<?= Url::to(['/customer/account/dashboard'])?>">
                                 <i class="fa fa-user-circle"></i>
                                  &nbsp; <?= Yii::t('app', 'Customer center')?>
                             </a>
                             <a class="dropdown-item" href="#">
                                 <i class="fa fa-heartbeat"></i>
                                 &nbsp; <?= Yii::t('app', 'My favorite')?>
                                 <span class="badge badge-danger">36</span>
                             </a>   
                             <a class="dropdown-item" href="#">
                                  <i class="fa fa-money"></i>
                                  &nbsp; <?= Yii::t('app', 'Orders center')?>
                             </a>
                             <a class="dropdown-item" href="<?= Url::to(['/customer/account/dashboard'])?>">
                                 <i class="fa fa-credit-card"></i>
                                  &nbsp; <?= Yii::t('app', 'Pending orders') ?>
                                  <span class="badge badge-danger">4</span>
                             </a>
                             <a class="dropdown-item" href="#">
                                 <i class="fa fa-truck"></i>
                                 &nbsp; <?= Yii::t('app', 'Shipping orders')?>
                                 <span class="badge badge-danger">36</span>
                             </a>
                       
                             <div class="dropdown-item last-dropdown-item d-flex flex-nowrap py-2">
                                 <a class="flex-grow-1 bind-account" href="#">
                                     <?= Yii::t('app', 'Bind other accounts') ?>
                                 </a>
                                 <a class="flex-grow-1 text-center" 
                                     href="<?= Url::to(['/customer/account/logout'])?>"
                                     data-method="post"
                                     data-confirm="<?= Yii::t('app', 'Please confirm')?>"
                                  ><?= Yii::t('app', 'Logout') ?></a>
                             </div>
                        </div>
                    </li>
                </ul>
             <?php endif; ?>
         </div>
         <div>
              <a href="<?= Url::to(['/checkout/cart/index']) ?>">
                  <i class="fa fa-shopping-cart"></i> 
                  <?= Yii::t('app', 'Shopping cart') ?>
              </a>
         </div>
     </div>
     <!-- 这部分在用户中心里也会显示 -->
     <div class="menu-bar d-flex align-items-center">
         <div class="logo-wrap mr-auto">
             <a href="<?= Yii::$app->homeUrl ?>">
                 <img src="<?= $this->getAssetUrl('img/yashop.png') ?>" />
             </a>
         </div>
         <ul class="nav">
             <li class="nav-item">
                  <a class="nav-link" title="" href="#">首页</a>
              </li>
             <li class="nav-item">
                  <a class="nav-link" title="" href="#">服装</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" title="" href="#">移动电源</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" title="" href="#">数码时尚</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" title="" href="#">家用电器</a>
              </li>
         </ul>
          <form class="search-form form-inline flex-nowrap">
                <input class="form-control rounded-0" 
                       type="search" 
                       placeholder="<?= Yii::t('app', 'Search')?> ..." 
                       aria-label="Search"
                >
                
                <?= Html::submitButton(Yii::t('app', 'Search'), [
                    'class' => 'btn btn-outline-secondary rounded-0'
                ]) ?>
          </form>
     </div>
</header>