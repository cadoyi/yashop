<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\widgets\ActiveForm;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $filterModel backend\models\customer\filters\CustomerFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 */
$this->title = Yii::t('app', 'Manage customers');
?>
<div class="grid-buttons">
    <?= Html::a(Yii::t('app', 'Add new customer'), ['create'], [
        'class' => 'btn btn-sm btn-primary',
    ])?>
</div>
<div class="grid-search">
    <?php $form = ActiveForm::begin([
        'id' => 'customer_search_form',
        'method' => 'get',
    ]) ?>
    <?= $form->field($filterModel, 'nickname') ?>
    <?= $form->field($filterModel, 'phone') ?>
    <?= $form->field($filterModel, 'email') ?>
    <?= Html::a(Yii::t('app', 'Reset'), ['index'], [
        'class' => 'btn btn-sm btn-secondary',
    ]) ?>
    <?= Html::submitButton(Yii::t('app', 'Search'), [
        'class' => 'btn btn-sm btn-primary',
    ]) ?>
    <?php ActiveForm::end() ?>
</div>
<?= GridView::widget([
    'id' => 'customer_grid',
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => CheckboxColumn::class,
        ],
        'id',
        'nickname',
        'phone',
        'email',
        'created_at:datetime',
        [
            'class' => ActionColumn::class,
            'template' => '{address} {update} {delete}',
            'buttons' => [
                 'address' => function($url, $model, $key) {
                    $url = ['/customer/address/index', 'cid' => $key];
                     return Html::a(Yii::t('app', 'Manage addresses'), $url, [
                         'class' => 'grid-link',
                     ]);
                 }
            ],
        ],
    ],
])?>