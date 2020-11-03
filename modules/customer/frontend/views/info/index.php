<?php
use yii\helpers\Html;
use yii\helpers\Url;
use cando\storage\widgets\ConfigUploader;
?>
<?php 
/**
 * 账户信息首页
 *
 * @var  $this yii\web\View
 */
?>
<div class="info-index">
<?php $form = $this->beginForm([
    'id' => 'customer_info_index',
])?>
    <div class="d-flex avatar-container">
        <?= $form->field($model, 'avatar')->widget(ConfigUploader::class, [
            'uploadUrl' => ['/core/file/upload', 'id' => 'customer-avatar'],
        ])->label(false)->hint('我的头像') ?>
        <div class="flex-grow-1 d-flex flex-column p-3 base-info columns">
            <div class="column">
                <span class="title">您的昵称</span>
                <span class="content">
                    <?= Html::encode($model->nickname) ?>    
                </span>
            </div>
            <div class="column">
                <span class="title">您的性别</span>
                <span class="content">
                    男
                </span>
            </div>
            <div class="column">
                <span class="title">登录时间</span>
                <span class="content">
                    <?php if($model->login_at): ?>
                        <?= $model->asDatetime('login_at') ?>
                    <?php else: ?>
                        未知
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column mb-3">
        <div style="width: 500px">
            <?= $form->field($model, 'nickname') ?>
            <?= $form->field($model, 'gender') ?>
            <?= $form->field($model, 'dob') ?>
            <?= $form->field($model, 'qq') ?>
            <div class="form-group">
                <div class="col-sm-10 offset-sm-2 p-0">
                    <?= Html::submitButton('立即保存', [
                        'class' => 'btn btn-sm btn-molv',
                    ]) ?>
                </div>
            </div>            
        </div>
        <div class="flex-grow-1"></div>
    </div>
<?php $this->endForm() ?>
</div>