<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $model cms\models\Tag
 *
 * 
 */
$this->title = Yii::t('app', 'Edit tag');
$this->addBreadcrumb(Yii::t('app', 'Manage article tags'), ['index']);
?>

<?php $form = $this->beginForm([
    'id'     => 'edit_cms_tag_form',
    'layout' => 'default',
]) ?>
   <?= $form->field($model, 'name') ?>
   <?= Html::submitButton(Yii::t('app', 'Save'), [
       'class' => 'btn btn-sm btn-primary',
   ]) ?>
<?php $this->endForm() ?>
