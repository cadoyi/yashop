<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\Tabs;

?>
<?php 
/**
 * @var  $this yii\web\View
 * @var  $key  customer ID
 * @var  $itemName 基本信息.
 * 
 * 
 */
$this->title = Yii::t('app', 'Edit customer');
$this->addBreadcrumb(Yii::t('app', 'Manage customers'), ['index']);
$tabItems = [
    'basic' => [
         'label' => Yii::t('app', 'Basic info'),
         'url'   => [ '/customer/customer/update', 'id' => $key ],
    ],
    'password' => [
         'label' => Yii::t('app', 'Password info'),
         'url'   => ['/customer/customer/password', 'id' => $key],
    ],
    'account' => [
         'label' => Yii::t('app', 'Account info'),
         'url'   => ['/customer/customer/account', 'id' => $key],
    ],
    'oauth' => [
         'label' => Yii::t('app', 'Oauth account'),
         'url'   => ['/customer/customer/oauth', 'id' => $key ],
    ],
    'address' => [
        'label' => Yii::t('app', 'Address info'),
        'url'   => ['/customer/address/index', 'cid' => $key],
    ],
];
unset($tabItems[$itemName]['url']);
$tabItems[$itemName]['content'] = $this->blocks['content'];
$tabItems[$itemName]['active'] = true;

?>
<?= Tabs::widget([
    'id' => 'customer_account_tabs',
    'items' => $tabItems,
    'tabContentOptions' => [
        'class' => 'tab-content p-3',
    ],
])?>
