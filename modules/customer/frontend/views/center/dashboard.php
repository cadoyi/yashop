<?php
use yii\helpers\Html;
use yii\helpers\Url;
//use yii\bootstrap4\ActiveForm;
//use common\models\customer\CustomerAccount;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $account frontend\models\customer\account\Customer{Account}
 * 
 */
$this->title = Yii::t('app', 'Customer center');

?>
<div class="dashboard pb-5">
    <div class="d-flex  border-bottom p-3">
        <div class="avatar-wrapper">
            <img src="<?= $this->getAssetUrl('img/user.jpg') ?>" />
            <a class="d-block text-center" href="#">修改头像</a>
        </div>
        <div class="base-title-info flex-grow-1 p-3">
            <div>您好:  
                <span><?= Html::encode($customer->nickname) ?></span>
                <span>&lt;客户昵称&gt;</span>
            </div>
            <div>登录时间: <?= $customer->login_at ?></div>
            <div>注册时间: <?= $customer->created_at ?></div>
        </div>
    </div>
    <div class="base-info d-flex flex-column">
        <div class="p-3">
            <?php $form = $this->beginForm([
               'id' => 'edit_customer_base_info_form',
               'options' => [
                    'class' => 'form-group-inline',
               ],
               
            ]) ?>
                 <?= $form->field($customer, 'nickname') ?>
                 <?= $form->field($customer, 'dob') ?>
                 <?= $form->field($customer, 'qq') ?>
                 <?= $form->field($customer, 'gender')
                    ->dropDownList([
                       Yii::t('app', 'Male'),
                       Yii::t('app', 'Female'),
                    ], [
                       'prompt' => '保密'
                    ]) 
                ?>
                 <div class="form-group">
                     <?= Html::submitButton(Yii::t('app', 'Save'), [
                         'class' => 'btn btn-sm btn-primary',
                     ]) ?>
                 </div>
            <?php $this->endForm() ?>
        </div>   
    </div>
    
</div>