<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\GridView;
use common\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\bootstrap4\ActiveForm;
use admin\models\User;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $self cando\web\ViewModel
 * @var  $filterModel 
 * @var  $dataProvider 
 */

$this->title = Yii::t('app', 'Manage user');
?>
<div class="grid-buttons">
    <a class="btn btn-sm btn-molv" href="<?= Url::to(['create'])?>">添加管理员</a>
</div>

<?= GridView::widget([
    'filterModel' => $filterModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => CheckboxColumn::class,
        ],
        'id',
        'username',
        'nickname',
        'is_active:boolean',
        'last_login_at:datetime',
        'last_login_ip', 
        [
            'class' => ActionColumn::class,
            'header' => Yii::t('app', 'Action'),
            'template' => '{role} {log} {update} {delete}',
            'buttons' => [
               'log' => function($url, $model, $key, $action) {
                    $title = Yii::t('app', 'Show log');
                    return $action->createButton($title, $url);
               },
               'role' => function($url, $model, $key, $action) {
                    $title = Yii::t('app', 'Role');
                    return $action->createButton($title, $url);
               },
            ],
        ],
    ],
])?>