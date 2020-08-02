<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use common\widgets\CKEditorInput;
?>
<?php 
/**
 * @var $this   yii\web\View
 * @var $model  cms\backend\models\article\Edit
 *
 */
$this->title = Yii::t('app', 'Edit article');
$this->addBreadcrumb(Yii::t('app', 'Manage articles'), ['index']);
?>
<?php $form = $this->beginForm([
    'id' => 'cms_article_edit_form', 
]) ?>
   <?= $form->field($model, 'title') ?>
   <?= $form->field($model, 'author') ?>
   <?= $form->field($model, 'category_id')->dropDownList($self->categoryHashOptions()) ?>
   <?= $form->field($model, 'content')->widget(CKEditorInput::class) ?>
   <?= $form->field($model, 'tagIds')
       ->checkboxList($self->tagHashOptions(), [
            'value' => $model->getTagIdsValue()
        ]) ?>
   <?= $form->field($model, 'meta_keywords')->textarea() ?>
   <?= $form->field($model, 'meta_description')->textarea() ?>
   <?= Html::submitButton(Yii::t('app', 'Save'), [
       'class' => 'btn btn-sm btn-primary',
   ]) ?>
<?php $this->endForm() ?>


