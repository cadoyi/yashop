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
        <div class="title">
            <img src="<?= $this->getAssetUrl('img/title.png') ?>" />
        </div>        
       <?= Menu::widget([
           'submenuTemplate' => '<ul class="submenus">{items}</ul>',
           'activateParents' => true,
           'items' => [
                [
                   'label' => Yii::t('app', 'Home page'),
                   'url'   => Yii::$app->homeUrl,
                   'icon'  => 'home', 
                ],
                [
                    'label' => Yii::t('app', 'Admin'),
                    'url' => '#',
                    'icon' => 'user-circle',
                    'template' => $childLinkTemplate,
                    'items' => [
                        [
                            'label' => Yii::t('app', 'User'),
                            'url' => ['/admin/user/index'],
                        ],
                        [
                            'label' => Yii::t('app', 'Role'),
                            'url' => ['/admin/role/index'],
                        ],
                    ],
                ],
                [
                    'label' => Yii::t('app', 'Article'),
                    'url' => '#',
                    'icon' => 'file-text-o',
                    'template' => $childLinkTemplate,
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Article category'),
                            'url' => ['/cms/category/index'],
                        ],
                        [
                            'label' => Yii::t('app', 'Article'),
                            'url' => ['/cms/article/index'],
                        ],
                    ],
               
                ],
                [
                    'label' => Yii::t('app', 'Customers'),
                    'url' => '#',
                    'icon' => 'users',
                    'template' => $childLinkTemplate,
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Customers'),
                            'url'  => ['/customer/customer/index'],
                        ],
                    ],

                ],
                [
                    'label' => Yii::t('app', 'Catalog'),
                    'url'  => '#',
                    'icon' => 'server',
                    'template' => $childLinkTemplate,
                    'items' => [
                         [
                             'label' => Yii::t('app', 'Brands'),
                             'url'   => ['/catalog/brand/index'],
                         ],
                         [
                             'label'  => Yii::t('app', 'Category'),
                             'url'    => ['/catalog/category/index'],
                         ],
                         [
                             'label' => Yii::t('app', 'Product'),
                             'url' => ['/catalog/product/index'],
                         ],
                         [
                              'label' => Yii::t('app', 'Product restore'),
                              'url' => ['/catalog/deleted-product/index'],
                         ]


                    ],
                
                ],
                [
                    'label' => Yii::t('app', 'Sales'),
                    'url' => '#',
                    'template' => $childLinkTemplate,
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Order'),
                            'url'   => ['/sales/order/index'],
                        ],
                    ],
                ],
                [
                    'label' => Yii::t('app', 'Frontend'),
                    'url' => '#',
                    'icon' => 'desktop',
                    'template' => $childLinkTemplate,
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Menu'),
                            'url'   => ['/front/menu/index'],
                        ],
                        [
                            'label' => Yii::t('app', 'Menu'),
                            'url'   => ['/system/menu/index'],
                        ],
                    ],
                ],
                [
                    'label' => Yii::t('app', 'Issue'),
                    'url'   => ['/issue/category/index'],
                ],
                [
                    'label' => Yii::t('app', 'System config'),
                    'url' => ['/core/config/edit'],
                    'icon' => 'cog',
                ],
           ],
       ])?>
    </div>
</aside> 