<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use common\assets\JsTreeAsset;
use backend\assets\basic\catalog\CategoryAsset;
JsTreeAsset::register($this);
CategoryAsset::register($this);
use catalog\models\widgets\Category;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $self catalog\backend\vms\category\Tree
 *
 * 
 */
$categoryHashOptions = Category::hashOptions();


$this->title = Yii::t('app', 'Manage categories');
?>

<div class="grid-buttons">
    <?= Html::a(Yii::t('app', 'Add new category'), ['create'], ['class' => 'btn btn-sm btn-primary'])?>
</div>
<div class="d-flex">
    <div class="my-3">
        <div><a class="root-category" href="#">分类结构预览</a></div>
        <div id="category_container" class="category-container">
        </div>
    </div>
</div>
<?= GridView::widget([
    'id' => 'catalog_category_grid',
    'filterModel' => $filterModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'title',
        'parent_id' => [
            'attribute' => 'parent_id',
            'filter' => $categoryHashOptions,
            'filterInputOptions' => [
                 'class' => 'form-control', 
                 'id' => null,
                 'encodeSpaces' => true,
            ],
            'value' => function($model, $key, $index, $column) use ($categoryHashOptions) {
                $parent_id = $model->parent_id;
                if(!is_null($parent_id)) {
                    $options = $categoryHashOptions;
                    return $options[$parent_id];
                }
                return null;
            }
        ],
        [
            'class' => ActionColumn::class,
            'header' => Yii::t('app', 'Action'),
            'template' => '{addchild} {update} {delete}',
            'buttons' => [
                'addchild' => function( $action, $model, $key ) {
                    return Html::a(Yii::t('app', 'Add child category'), ['create', 'parent' => $key], [
                        'class' => 'grid-link',
                    ]);
                }
            ],
        ]
    ],
])?>
<?php $this->beginScript() ?>
<script>
    $('#category_container').jstree({
        'core': {
            'data': {
               'url': '<?= Url::to(['load'], true)?>',
                'data': function( node ) {
                    return { 'id': node.id };
                }                
            }
        }
    });
</script>
<?php $this->endScript() ?>