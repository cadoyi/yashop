<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $filterModel customer\models\filters\CustomerAddressFilter
 * @var  $dataProvider yii\data\ActiveDataProvider
 * @var  $models customer\models\CustomerAddress[]
 * @var  $customer customer\models\Customer
 * 
 */

$addresses = $dataProvider->models;
$this->title = Yii::t('app', 'Address list');
?>    
<div class="text-left border-bottom p-3 mb-3">
    <?= Html::a(Yii::t('app', 'Add new address'), ['create'], ['class' => 'btn btn-sm btn-primary']) ?>
</div>
<div class="d-flex flex-wrap">

    <?php foreach($addresses as $address): ?>
        <div class="card m-1" style="width: 320px;">
            <div class="card-header d-flex flex-nowrap justify-content-arround">
                <div class="tag tag-primary mr-auto">
                    <?= Html::encode( $address->tag ) ?>
                </div>
                <div class="d-flex flex-nowrap">
                    <?php if($address->isDefault()): ?>
                        <div class="default-address mr-2">默认地址</div>
                    <?php endif; ?>
                    <a href="<?= Url::to(['update', 'cid' => $customer->id, 'id' => $address->id ]) ?>">
                        <i class="fa fa-pencil"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="namephone">
                    <?= Html::encode($address->name ) ?>
                    <?= Html::encode($address->phone ) ?>
                </div>
                <div class="">
                    <?= Html::encode($address->region . $address->city . $address->area )?>
                    <?= Html::encode($address->street) ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


