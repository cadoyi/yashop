<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use customer\models\Customer;
use customer\models\CustomerGroup;
use core\widgets\Uploader;
?>
<?php 
/**
 * @var  $this yii\web\View
 * 
 */
?>
<?php $this->beginBlock('content') ?>
    <div class="mw-500">
        <?php $form = ActiveForm::begin(['id' => 'customer_basic_form']) ?>
            <?= $form->field($customer, 'avatar')->widget(Uploader::class, [
                'uploadId' => 'customer/customer/avatar',
            ]) ?>
            <?= $form->field($customer, 'nickname') ?>
            <?= $form->field($customer, 'qq') ?>
            <?= $form->field($customer, 'gender')
                ->dropDownList([
                  Yii::t('app', 'Male'),
                  Yii::t('app', 'Female'),
                ], ['prompt' => '保密']) ?>
            <?= $form->field($customer, 'is_active')
                ->dropDownList(Customer::isActiveHashOptions())
            ?>
            <?= $form->field($customer, 'dob') ?>
            <?= $form->field($customer, 'group_id')->dropDownList(CustomerGroup::hashOptions()) ?>
            <?= Html::submitButton(Yii::t('app', 'Save'), [
                'class' => 'btn btn-sm btn-primary',
            ]) ?>
        <?php ActiveForm::end() ?>
    </div>
<?php $this->endBlock(); ?>

<?php $this->beginContent('@customer/backend/views/customer/_update.php', [
   'key' => $customer->id,
   'itemName' => 'basic',
]) ?>
<?php $this->endContent() ?>