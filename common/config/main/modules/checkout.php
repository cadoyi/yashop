<?php
Yii::setAlias('@checkout', '@modules/checkout');

return [
    'class' => 'checkout\Module',
    'layoutPath' => '@app/views/layouts',
];