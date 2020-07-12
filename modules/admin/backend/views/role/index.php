<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\bootstrap4\ActiveForm;

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
    <?= Html::a(Yii::t('app', 'Add role'), ['create'], ['class' => 'btn btn-sm btn-primary'])?>
</div>
<div class="grid-search">
    <?php $form =  ActiveForm::begin([
        'id' => 'role_search_form',
        'method' => 'get',
    ]) ?>
    <?= $form->field($filterModel, 'name') ?>
    <?= Html::a(Yii::t('app', 'Reset'), ['index'], [
        'class' => 'btn btn-sm btn-secondary'
    ])?>
    <?= Html::submitButton(Yii::t('app', 'Search'), [
         'class' => 'btn btn-sm btn-primary',
    ])?>
    <?php ActiveForm::end() ?>
</div>
<?= GridView::widget([
   'id' => 'admin_role_grid',
   'dataProvider' => $dataProvider,
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
           'urlCreator' => function($action, $model, $key, $index, $column) {
                return [$action, 'name' => $model->name];
           }
       ],
   ],
])?>