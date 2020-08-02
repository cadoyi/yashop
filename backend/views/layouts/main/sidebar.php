<?php
use yii\bootstrap4\Html;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;
use cando\widgets\Menu;
use common\widgets\Alert;
?>
<?php 
/**
 * 主要的 layout 文件
 * 
 * @var  $this yii\web\View
 *
 */
?>
<aside class="main-sidebar">
    <div class="main-sidebar-title">
        <img class="w-100" src="<?= $this->getAssetUrl('img/title.png') ?>" />
    </div>
    <div class="menus">
       <?= Menu::widget([
           'activateParents' => true,
           'items' => [
                [
                   'label' => Yii::t('app', 'Home page'),
                   'url'   => Yii::$app->homeUrl,
                   'icon'  => 'home', 
                ],
                [
                    'label' => Yii::t('app', 'User center'),
                    'url' => '#',
                    'icon' => 'user-circle',
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Manage users'),
                            'url' => ['/admin/user/index'],
                        ],
                        [
                            'label' => Yii::t('app', 'Manage roles'),
                            'url' => ['/admin/role/index'],
                        ],
                    ],
                ],
                [
                    'label' => Yii::t('app', 'Article'),
                    'url' => '#',
                    'icon' => 'file-text-o',
                    'items' => [
                        [
                            'label'  => Yii::t('app', 'Article tag'),
                            'url'    => ['/cms/tag/index'],
                        ],
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
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Customer group'),
                            'url'   => ['/customer/group/index'],
                        ],
                        [
                            'label' => Yii::t('app', 'Customers'),
                            'url'  => ['/customer/customer/index'],
                        ],
                    ],

                ],
                [
                    'label' => Yii::t('app', 'Store'),
                    'url'   => '#',
                    'icon'  => 'handshake-o',
                    'items' => [
                         [
                             'label' => Yii::t('app', 'Manage stores'),
                             'url'   => ['/store/store/index'],
                         ],
                    ],
                ],
                [
                    'label' => Yii::t('app', 'Catalog'),
                    'url'  => '#',
                    'icon' => 'server',
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
                             'label' => Yii::t('app', 'Product type'),
                             'url' => ['/catalog/type/index'],
                         ],
                         [
                             'label' => Yii::t('app', 'Supplier'),
                             'url' => ['/catalog/supplier/index'],
                         ],
                         [
                             'label' => Yii::t('app', 'Product'),
                             'url' => ['/catalog/product/index'],
                         ],
                         [
                              'label' => Yii::t('app', 'Product restore'),
                              'url' => ['/catalog/product/deleted'],
                         ]


                    ],
                
                ],
                [
                    'label' => Yii::t('app', 'System'),
                    'url' => '#',
                    'icon' => 'desktop',
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Menu action'),
                            'url'   => ['/system/menu-action/index'],
                        ],
                        [
                            'label' => Yii::t('app', 'Menu'),
                            'url'   => ['/system/menu/index'],
                        ],
                    ],

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