<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\bootstrap4\ActiveForm;
use modules\admin\models\User;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $params cando\web\ViewModel
 * @var  $filterModel 
 * @var  $dataProvider 
 */
$filterModel = $params->filterModel;
$dataProvider = $params->dataProvider;

$this->title = Yii::t('app', 'Manage user');
?>
<div class="grid-buttons">
    <a class="btn btn-sm btn-primary" href="<?= Url::to(['create'])?>">添加管理员</a>
</div>
<div class="grid-search">
    <?php $form = ActiveForm::begin([
        'id' => 'search-form',
        'method' => 'get',
    ]) ?>
        <?= $form->field($filterModel, 'id') ?>
        <?= $form->field($filterModel, 'username') ?>
        <?= $form->field($filterModel, 'nickname') ?>
        <?= $form->field($filterModel, 'is_active')->dropDownList([
            User::STATUS_ACTIVE => Yii::t('app', 'Enabled'),
            User::STATUS_INACTIVE => Yii::t('app', 'Disabled'),
        ], ['prompt' => Yii::t('app', 'Please select')]) ?>

            <?= Html::a(Yii::t('app', 'Reset'), ['index'], [
                'class' => 'btn-reset btn btn-sm btn-outline-secondary',
            ])?>
            <?= Html::submitButton(Yii::t('app', 'Search'), [
                'class' => 'btn btn-sm btn-primary',
            ])?>

    <?php ActiveForm::end() ?>
</div>
<?= GridView::widget([
    'filterModel' => null,
    'dataProvider' => $dataProvider,
    'layout' => "{items}\n{pager}\n{summary}",
    'columns' => [
        [
            'class' => CheckboxColumn::class,
        ],
        'id',
        'username',
        'nickname',
        'last_login_at:datetime',
        'last_login_ip', 
        [
            'class' => ActionColumn::class,
            'header' => Yii::t('app', 'Operation'),
            'template' => '{role} {log} {update} {delete}',
            'buttons' => [
               'log' => function($url, $model, $key) {
                    return Html::a(Yii::t('app', 'Show log'), $url, [
                        'class' => 'grid-link',
                    ]);
               },
               'role' => function($url, $model, $key) {
                    return Html::a(Yii::t('app', 'Role'), $url, [
                        'class' => 'grid-link',
                    ]);
               },
            ],
        ],
    ],
])?>