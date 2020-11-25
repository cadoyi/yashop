<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $account frontend\models\customer\account\Customer{Account}
 * 
 */
$identity = Yii::$app->user->identity;


$this->title = Yii::t('app', 'Customer center');
?>
<div class="center-dashboard pb-5">
    <div class="d-flex header">
        <div class="avatar-wrapper">
            <img 
            <?php if($identity->avatar): ?>
                 src="<?= Yii::$app->storage->getUrl($identity->avatar, 90) ?>"
            <?php else: ?>
                 src="<?= $this->getAssetUrl('img/user.jpg') ?>"
            <?php endif; ?>
            />
        </div>
        <div class="base-title-info flex-grow-1 d-flex flex-nowrap align-items-center text-center">
            <div class="flex-grow-1">
                <a href="<?= Url::to(['/customer/address/index'])?>">我的收货地址</a>
            </div>
            <div class="flex-grow-1">
                <a href="#">我的物流信息</a>
            </div>
            <div class="flex-grow-1">
                <a href="#"><i class="fa fa-shopping-cart"></i> 我的购物车</a>
            </div>
        </div>
    </div>
    <section class="p-3 border-bottom order-section">
        <div class="section-title">
            <h3>我的订单</h3>
        </div>
        <div class="section-content d-flex flex-nowrap text-center py-5">
            <div class="flex-grow-1">
                <a href="#">
                    <i class="fa fa-hourglass-start"></i>
                    待付款
                </a>
            </div>
            <div class="flex-grow-1">
                <a href="#">
                    <i class="fa fa-credit-card-alt"></i>
                    待发货
                </a>
            </div>
            <div class="flex-grow-1">
                <a href="#">
                    <i class="fa fa-truck"></i>
                    已发货
                </a>
            </div>
            <div class="flex-grow-1">
                <a href="#">
                    <i class="fa fa-shopping-cart"></i>
                    已完成
                </a>
            </div>
            <div class="flex-grow-1">
                <a href="#">
                    <i class="fa fa-shopping-cart"></i>
                    已退款
                </a>
            </div>        
        </div>
    </section>
    <section class="p-3 border-bottom">
        <div class="section-title">
            <h3>最新物流</h3>
        </div>
        <div class="section-content py-5">
            暂无任何物流信息
        </div>
    </section>

    
</div>