<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('@locale', dirname(dirname(__DIR__)) . '/locale');
Yii::setAlias('@modules', dirname(dirname(__DIR__)) . '/modules');

Yii::setAlias('@admin', dirname(dirname(__DIR__)) . '/modules/admin');
Yii::setAlias('@core', dirname(dirname(__DIR__)) . '/modules/core');
Yii::setAlias('@cms', dirname(dirname(__DIR__)) . '/modules/cms');
Yii::setAlias('@catalog', dirname(dirname(__DIR__)) . '/modules/catalog');
Yii::setAlias('@customer', dirname(dirname(__DIR__)) . '/modules/customer');
Yii::setAlias('@store', dirname(dirname(__DIR__)) . '/modules/store');
Yii::setAlias('@front', dirname(dirname(__DIR__)) . '/modules/front');
Yii::setAlias('@review', dirname(dirname(__DIR__)). '/modules/review');
Yii::setAlias('@sales', dirname(dirname(__DIR__)) . '/modules/sales');
Yii::setAlias('@checkout', dirname(dirname(__DIR__)) . '/modules/checkout');
Yii::setAlias('@catalogsearch', dirname(dirname(__DIR__)) . '/modules/catalogsearch');
Yii::setAlias('@wishlist', dirname(dirname(__DIR__)). '/modules/wishlist');

Yii::setAlias('@media', dirname(dirname(__DIR__)) . '/media');
Yii::setAlias('@mediaUrl', '/media');