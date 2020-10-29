<?php

return [
   'tab' => 'admin',
   'fieldsets' => [
       'captcha' => [
           'label' =>'Captcha code',
           'fields' => [
               'enabled' => [
                   'label' => 'Login captcha enabled',
                   'type' => 'select',
                   'defaultValue' => 1,
                   'selectItems' => [
                       "0" => 'Disabled',
                       "1" => 'When login failed',
                       "2" => 'Enabled',
                   ],
               ],
               'retry_count' => [
                   'label' => 'Captcha retry count',
                   'type'  => 'text',
                   'defaultValue' => 3,
                   'validators' => [
                       ['required'],
                       ['integer', 'min' => 1],
                   ],
               ],
           ],
       ],
       'remember' => [
           'label' => 'Remember me',
           'fields' => [
                'enabled' => [
                     'label' => 'Remember me',
                     'type'  => 'select',
                     'defaultValue' => 1,
                     'selectItems' => [
                         "0" => 'Disabled',
                         "1" => 'Enabled',
                     ],
                ],
                'second' => [
                     'label' => 'Remember me time',
                     'type' => 'text',
                     'defaultValue' => 7200,
                     'validators' => [
                         ['required'],
                         ['integer'],
                     ],
                ], 
           ],
       ],
   ],
];