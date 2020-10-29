<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
?>
<div class="layui-side layui-bg-black">
    <div id="sidebar" class="layui-side-scroll">
      <?= Menu::widget([
           'options' => [
               'class' => 'layui-nav layui-nav-tree',
               'lay-filter' => 'something',
           ],
           'itemOptions' => [
                'class' => 'layui-nav-item',
           ],
           'submenuTemplate' => "\n<ul class=\"layui-nav-child\">\n{items}\n</ul>\n",
           'labelTemplate' => '<a href="#" data-pjax="1">{label}</a>',
           'activeCssClass' => 'layui-this',
           'items' => [
                [
                    'label' => '首页',
                    'url'   => ['/site/index'],
                ],
                [
                    'label'  => '后台管理',
                    'items'  => [
                         [
                             'label' => '用户管理',
                             'url'   => ['/admin/user/index'],
                         ],
                         [
                              'label' => '角色管理',
                              'url'  => ['/admin/role/index'],
                         ],
                    ],
                ],
                [
                    'label' => '所有商品',
                    'items' => [
                        [
                            'label' => '列表一',
                            'url'  => '#',
                        ],
                        [
                            'label' => '列表二',
                            'url'  => '#',
                        ],
                        [
                            'label' => '列表三',
                            'url'  => '#',
                        ],
                        [
                            'label' => '列表四',
                            'url'  => '#',
                        ],                      
                    ],
                ],
                [
                    'label' => '解决方案',
                    'items' => [
                        [
                            'label' => '列表一',
                            'url'  => '#',
                        ],
                        [
                            'label' => '列表二',
                            'url'  => '#',
                        ],
                        [
                            'label' => '列表三',
                            'url'  => '#',
                        ],
                        [
                            'label' => '列表四',
                            'url'  => '#',
                        ],                      
                    ],
                ],
                [
                    'label' => '云市场',
                ],
                [
                     'label' => '发布商品',
                ],
                [
                    'label' => Yii::t('app', 'System config'),
                    'url' => ['/core/config/edit'],
                    'icon' => 'cog',
                ],
           ],
      ])?>
    </div>
</div>
<?php $this->beginScript() ?>
<script>
    $('#sidebar').on('click', 'a', function( e ) {
        $.pjax.click(e, '#layui_body');
    });
</script>
<?php $this->endScript() ?>