<?php
use yii\helpers\Html;

?>
<?php
/**
 * @var  $this yii\web\View
 * @var  $params cando\web\ViewModel
 * @var  $name 异常名称
 * @var  $message 错误消息
 * @var  $exception 异常类
 */
$name      = $params->name;
$message   = $params->message;
$exception = $params->exception;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        The above error occurred while the Web server was processing your request.
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you.
    </p>

</div>
