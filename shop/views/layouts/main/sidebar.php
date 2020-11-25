<?php
use yii\bootstrap4\Html;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\Menu;
use common\widgets\Alert;
?>
<?php 
/**
 * 主要的 layout 文件
 * 
 * @var  $this yii\web\View
 *
 */
$childLinkTemplate = '<a class="has-child" href="{url}">{label}<i class="fa fa-caret-left"></i><i class="fa fa-caret-down"></i></a>';
?>
<aside id="layout_sidebar" class="layout-sidebar">
    <div class="menus">
        <a class="title" href="">
            Yashop 卖家中心
        </a>        
       <?= Menu::widget([
           'submenuTemplate' => '<ul class="submenus">{items}</ul>',
           'activateParents' => true,
           'items' => [
                [
                   'label' => '工作台',
                   'url'   => Yii::$app->homeUrl,
                   'icon'  => 'home', 
                ],
                [
                    'label' => '店铺管理',
                    'url'  => '#',
                    'icon' => 'server',
                    'items' => [
                        [
                            'label' => '角色设置',
                            'url'   => '#',
                        ],
                    ],
                ],
                [
                    'label' => '宝贝中心',
                    'url'  => '#',
                    'icon' => 'server',
                    'template' => $childLinkTemplate,
                    'items' => [
                         [
                             'label' => Yii::t('app', 'Product'),
                             'url' => ['/product/index'],
                         ],


                    ],
                
                ],
                [
                    'label' => '订单管理',
                    'url' => '#',
                    'template' => $childLinkTemplate,
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Order'),
                            'url'   => ['/sales/order/index'],
                        ],
                    ],
                ],
           ],
       ])?>
    </div>
</aside> 