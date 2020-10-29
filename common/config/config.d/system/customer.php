<?php

return [
   'tab' => 'customer',
   'fieldsets' => [
       'group' => [
           'label' => 'Customer group',
           'fields' => [
               'default' => [
                   'label'     => 'Default customer group',
                   'type'      => 'select',
                   'defaultValue' => 1,
                   'validators' => [
                        ['required'],
                   ],
                   'selectItems' => '\customer\models\CustomerGroup::hashOptions',
               ],
           ],
       ],
       'login' => [
           'label' => 'Customer login',
           'fields' => [
               'remember_me' => [
                   'label' => 'Allow remember me',
                   'type'  => 'select',
                   'defaultValue' => 1,
                   'selectItems' => [
                         0 => 'Disabled',
                         1 => 'Enabled',
                    ],
                    'validators' => [
                        ['required'],
                        ['boolean'],
                    ],
               ],
               'remember_time' => [
                   'label' => 'Remember me time',
                   'type'  => 'text',
                   'defaultValue' => 7200,
                   'validators' => [
                       ['required'],
                       ['integer', 'min' => 60, 'max' => 2592000],
                   ],
               ], 
           ], 
       ], 
   ], 
];