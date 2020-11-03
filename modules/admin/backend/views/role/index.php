<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\GridView;
use common\grid\ActionColumn;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $self cando\web\ViewModel
 * @var  $filterModel cado\rbac\RoleFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 * 
 */
$this->title = Yii::t('app', 'Manage roles');
?>
<div class="grid-buttons">
    <?= Html::a(Yii::t('app', 'Add role'), ['create'], ['class' => 'btn btn-sm btn-molv'])?>
</div>

<?= GridView::widget([
   'id' => 'admin_role_grid',
   'dataProvider' => $dataProvider,
   'filterModel'  => $filterModel,
   'columns' => [
       'name',
       'label' => [
           'attribute' => 'label',
           'value' => function($model) {
                return Yii::t('app', $model->label);
           }
       ],
       [
           'class' => ActionColumn::class,
           'template' => '{update} {delete}',
           'header'   => Yii::t('app', 'Action'),
           'urlCreator' => function($action, $model, $key, $index, $column) {
                return [$action, 'name' => $model->name];
           }
       ],
   ],
])?>