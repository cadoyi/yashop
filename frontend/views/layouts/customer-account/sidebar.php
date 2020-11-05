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
                        'label' => '帐号绑定',
                        'url' => ['dashboard'],
                    ],
                    [
                        'label' => '地址管理',
                        'url' => ['/customer/address/index'],
                    ],
                ],     
            ],
        ],
    ])?>
</div>