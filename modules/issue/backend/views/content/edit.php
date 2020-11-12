<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\widgets\CKEditorInput;
?>
<?php 
/**
 *
 * @var  $this yii\web\View
 * @var  $model issue\models\Content
 * @var  $menu  issue\models\Menu
 * @var  $category issue\models\Category
 */
$category = $model->category;
$menu = $model->menu;

$this->addBreadcrumb($category->title, ['/issue/category/index']);
$this->addBreadcrumb($menu->title, ['/issue/menu/index', 'c' => $category->id]);
$this->addBreadcrumb('问题列表', ['index', 'mid' => $menu->id]);
$this->title = '编辑问题';
?>
<?php $form = $this->beginForm([
    'id' => 'edit_menu_content_form',
]) ?>
    <?= $form->field($model, 'title') ?>
    <?= $form->field($model, 'content')->widget(CKEditorInput::class, [
        'options' => [
            'style' => [
                'min-height' => '500px',
            ],
        ],
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton('立即保存', [
            'class' => 'btn btn-sm btn-molv',
        ])?>
    </div>

<?php $this->endForm() ?>