<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
?>
<?php 
/**
 * customer sidebar
 *
 * @var  $this yii\web\View
 */
?>
<div class="sidebar customer-sidebar">
    <?= Menu::widget([
        'labelTemplate' => '<span>{label}</span>',
        'items' => [
            [
                'label' => '全部功能',
                'url'   => ['/customer/center/dashboard'],
                'options' => [
                    'class' => 'customer-center-home',
                ],
            ],
            [
                'label' => '订单中心',
                'items' => [
                    [
                        'label' => '我的订单',
                        'url' => '#',
                    ],
                    [
                        'label' => '我的评价',
                        'url' => ['dashboard'],
                    ],
                ],     
            ],
            [
                'label' => '我的活动',
                'items' => [
                    [
                        'label' => '我的收藏',
                        'url' => ['/wishlist/product/index'],
                    ],
                    [
                        'label' => '我的积分',
                        'url' => ['dashboard'],
                    ],
                    [
                        'label' => '我的优惠',
                        'url' => ['dashboard'],
                    ],
                    [
                        'label' => '我的足迹',
                        'url' => ['dashboard'],
                    ],
                ],     
            ],
            [
                'label' => '客户服务',
                'items' => [
                    [
                        'label' => '我的发票',
                        'url' => ['dashboard'],
                    ],
                    [
                        'label' => '退换货服务',
                        'url' => ['dashboard'],
                    ],
                ],     
            ],
        ],
    ])?>
</div>