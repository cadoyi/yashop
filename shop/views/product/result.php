<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php 
/**
 * pjax 执行结果.
 *
 * @var  $this yii\web\View
 * @var  $success boolean
 */
?>
<div id="pjax_result">
<?php if($success): ?>
    <h1>操作成功</h1>
<?php endif; ?>
</div>
<script>
    setTimeout(function() {
        var modal = $('#pjax_result').closest('.modal');
        if(modal.length) {
            modal.modal('hide');
        }
        location.reload();
    }, 2000);
</script>
