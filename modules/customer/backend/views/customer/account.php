<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\grid\ActionColumn;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $customer customer\models\Customer
 * @var  $filterModel customer\models\filters\CustomerAccountFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 */
$accounts = $dataProvider->getModels();
$types = ArrayHelper::getColumn($accounts, 'type');
?>
<?php $this->beginBlock('content') ?>
<div class="grid-buttons">
     <?php if(!in_array('email', $types, true)): ?>
         <?= Html::a(Yii::t('app', 'Binding email account'), ['add-account', 'id' => $customer->id, 'type' => 'email'], [
            'class' => 'btn btn-sm btn-primary',
         ])?>
     <?php endif; ?>
     <?php if(!in_array('phone', $types, true)): ?>
         <?= Html::a(Yii::t('app', 'Binding phone account'), ['add-account', 'id' => $customer->id , 'type' => 'phone'], [
             'class' => 'btn btn-sm btn-primary',
         ])?>
     <?php endif; ?>
</div>
   <?= GridView::widget([
       'id' => 'customer_account_grid',
       'dataProvider' => $dataProvider,
       'columns' => [
           'type' => [
                'attribute' => 'type',
            ],
           'username',
           'created_at:datetime',
           [
                'class' => ActionColumn::class,
                'template' => '{delete}',
                'urlCreator' => function($action, $account, $key) use ($customer){
                    return [
                        'delete-account', 
                        'cid' => $customer->id, 
                        'id'  => $key,
                    ];
                }
            ],
        ],
   ])?>
<?php $this->endBlock() ?>
<?php $this->beginContent('@customer/backend/views/customer/_update.php', [
    'key'      => $customer->id,
    'itemName' => 'account',
]) ?>

<?php $this->endContent() ?>