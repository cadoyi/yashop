<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?php 
/**
 * @var  $this yii\web\View
 * 
 */
$this->title = Yii::t('app', 'Bind account');
$customer = Yii::$app->user->identity;
?>
<div class="customer-account-bind px-3 py-5">
<table class="table">
    <?php if($phone = $customer->typePhone): ?>
    <tr>
        <th>手机绑定</th>
        <td>您已经绑定手机号 <?= Html::encode($phone->username) ?>, 您可以使用这个手机号来登录</td>
        <td class="text-success"><i class="fa fa-check-circle"></i> 已设置</td>
        <td><a href="#">修改</a></td>
    </tr>
    <?php else: ?>
    <tr>
        <th>手机绑定</th>
        <td>您还未绑定您的手机账号</td>
        <td class=" text-warning"><i class="fa fa-warning"></i> 未设置</td>
        <td><a href="#">绑定</a></td>
    </tr>
    <?php endif; ?>
    <?php if($email = $customer->typeEmail): ?>
    <tr>
        <th>邮箱绑定</th>
        <td>您已经绑定邮箱 <?= Html::encode($email->username) ?>, 您可以使用这个邮箱来登录</td>
        <td class="text-success"><i class="fa fa-check-circle"></i> 已设置</td>
        <td><a href="#">修改</a></td>
    </tr>
    <?php else: ?>
    <tr>
        <th>邮箱绑定</th>
        <td>您还未绑定您的手机账号</td>
        <td class="text-warning"><i class="fa fa-warning"></i> 未设置</td>
        <td><a href="#">绑定</a></td>
    </tr>
    <?php endif; ?>
    <tr>
        <th>微信绑定</th>
        <td>您还未绑定您的手机账号</td>
        <td class="text-warning"><i class="fa fa-warning"></i>  未设置</td>
        <td><a href="#">绑定</a></td>
    </tr>
</table>
</div>