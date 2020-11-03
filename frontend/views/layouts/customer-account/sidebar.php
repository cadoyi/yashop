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
                'label' => '帐号管理',
                'items' => [
                    [
                        'label' => '个人信息',
                        'url' => ['/customer/info/index'],
                    ],
                    [
                        'label' => '账号安全',
                        'url' => ['/customer/info/security'],
                    ],
                    [
                        'label' => '我的收藏',
                        'url' => ['dashboard'],
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