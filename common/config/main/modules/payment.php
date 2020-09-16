<?php
Yii::setAlias('@payment', '@modules/payment');
return [
    'class' => 'payment\Module',
    'layoutPath' => '@app/views/layouts',
];