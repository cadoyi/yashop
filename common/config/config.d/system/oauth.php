<?php

return [
   'label' => 'Oauth accounts',
   'tab'   => 'customer',
   'fieldsets' => [
       'weixin' => [
           'label' => 'Wechat login',
            'fields' => [
                'app_id' => [
                    'label' => 'APP ID',
                    'type' => 'text',
                ],
                'app_secret' => [
                    'label' => 'App Secret',
                    'type'  => 'text',
                ],
                'redirect_uri' => [
                    'label' => 'Redirect uri',
                    'type'  => 'textarea',
                    'hint'  => 'Please remove spaces and newline characters',
                ],
            ],
       ], // oauth/weixin
   ], //<== oauth[fieldsets]
];