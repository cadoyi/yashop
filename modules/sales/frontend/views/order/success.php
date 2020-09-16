<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<?php 
/**
 * 订单支付成功通知
 *
 * @author  zhangyang <zhangyangcado@qq.com>
 */
$this->title = '订单支付成功!';
?>
<div class="d-flex flex-column justify-content-center align-items-center">
    <div class="alert alert-success" style="width: 500px;">
        <h1 class="text-center h3">支付成功</h1>
        <p>您的订单 #<?= Html::encode($orderPaid->increment_id) ?> 支付成功! </p>
        <p>您将在 <span id="count_down" class="text-danger h5">4</span> 秒后跳转到订单页面</p>
    </div>
    <div class="buttons">
        <a id="backtoorder" 
           class="btn btn-sm btn-outline-secondary" 
           href="<?= Url::to(['/sales/customer-order/processing'])?>"
        >
           &lt;&lt; 立即返回
       </a>
    </div>
</div>
<?php $this->beginScript() ?>
<script>
    var counter = $('#count_down');
    var countDown = function() {
        var text = +counter.text();
        if(text > 0) {
            setTimeout(function() {
                counter.text(text - 1);
                countDown();
            }, 1000);
        } else {
            $('#backtoorder').trigger('click');
            $('#backtoorder').get(0).click();
        }
    }
    countDown();
</script>
<?php $this->endScript() ?>

