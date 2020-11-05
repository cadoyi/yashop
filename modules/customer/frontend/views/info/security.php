<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * 账户安全
 *
 * @var  $this yii\web\View
 * @var  $model customer\models\Customer
 */
$identity = Yii::$app->user->identity;
?>
<div class="info-security">
    <section class="base-info mb-5">
        <div class="section-title">
            <h3>您的基础信息</h3>
        </div>
        <div class="section-content">
            <div class="columns">
                <div class="column">
                    <span class="title">会员昵称</span>
                    <span class="content">
                        <?= Html::encode($identity->nickname) ?>        
                    </span>
                </div>
                <div class="column">
                    <span class="title">登录邮箱</span>
                    <span class="content">
                        <?php if($identity->email): ?>
                            &lt;<?= Html::encode($identity->email) ?>&gt;
                        <?php else: ?>
                             未绑定
                        <?php endif; ?>
                    </span>                    
                </div>
                <div class="column">
                    <span class="title">绑定手机</span>
                    <span class="content">
                        <?php if($identity->phone): ?>
                            <?= Html::encode($identity->phone) ?>
                        <?php else: ?>
                            未绑定
                        <?php endif; ?>
                    </span>             
                </div>
            </div>
        </div>
    </section>
    <section class="service-info">
        <div class="section-title">
            <h3>您的安全服务</h3>
        </div>
        <div class="section-content">
            <div class="progresser p-3 mb-3">
                <div><small>安全等级: 低</small></div>
                <div class="flex-grow-1">
                    <div class="progress">
                        <div class="progress-bar bg-danger" 
                           style="width: 25%;" >
                           25%
                        </div>
                    </div>
                </div>
            </div>
            <table class="table">
                <tbody>
                    <tr>
                        <td success>
                            <i class="fa fa-check"></i>
                            已完成
                        </td>
                        <td>身份认证</td>
                        <td>用于提升账号的安全性和信任级别。认证后的有卖家记录的账号不能修改认证信息。</td>
                        <td><a href="#">查看</a></td>
                    </tr>
                    <tr>
                        <td unset>
                            <i class="fa fa-warning"></i>
                            未设置
                        </td>
                        <td>登录密码</td>
                        <td>安全性高的密码可以使账号更安全。建议您定期更换密码，且设置一个包含数字和字母，并长度超过6位以上的密码。</td>
                        <td><a href="#">设置</a></td>
                    </tr>
                    <tr>
                        <td success><i class="fa fa-check"></i> 已完成</td>
                        <td>密保问题</td>
                        <td>是您找回登录密码的方式之一。建议您设置一个容易记住，且最不容易被他人获取的问题及答案，更有效保障您的密码安全。</td>
                        <td><a href="#">修改</a></td>
                    </tr>
                    <tr>
                        <td success><i class="fa fa-check"></i> 已完成</td>
                        <td>绑定手机</td>
                        <td>绑定手机后，您即可享受淘宝丰富的手机服务，如手机找回密码等。</td>
                        <td><a href="#">查看</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>