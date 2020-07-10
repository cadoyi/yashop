<?php
/**
 * 后台配置
 *
 * 
 */
return [
    'tabs' => [
        'general' => [
            'label' => 'General',
        ],
        'admin' => [
            'label' => 'Admin',
        ],
    ],
    'sections' => [
       'web' => [
           'tab' => 'general',
           'label' => 'WEB',
           'fieldsets' => [
                'header' => [
                    'fields' => [
                         'title' => [
                              'type' => 'text',
                              'defaultValue' => 'Website title',
                              'validators' => [
                                  ['required'],
                                  ['string', 'max' => 255],
                              ],
                         ],
                         'description' => [
                              'type' => 'textarea',
                              'defaultValue' => 'Website description',
                              'validators' => [
                                  ['required'],
                                  ['string'],
                              ],
                         ],
                    ],
                ],
                'footer' => [
                     'fields' => [
                         'test' => [
                             'visible' => true,
                             'type' => 'select',
                             'defaultValue' => 1,
                             'typeItems' => [
                                 'No',
                                 'Yes',
                             ],
                             'validators' => [
                                  ['boolean'],
                                  //['default', 'value' => 1],
                             ],
                             'options' => [
                                 'prompt' => 'Please select',
                             ],
                         ],
                         'test2' => [
                             'type' => 'select',
                             'multiple' => true,
                             'defaultValue' => ['a', 'b'],
                             'typeItems' => [
                                 'a' => 'A',
                                 'b' => 'B',
                                 'c' => 'C',
                             ],
                         ],
                         'checkbox' => [
                             'label' => 'This is checkbox',
                             'type' => 'checkbox',
                             'defaultValue' => 0,
                         ],
                         'radio' => [
                             'label' => 'Radio input',
                             'type' => 'radio',
                         ],
                         'checkboxList' => [
                             'type' => 'checkboxList',
                             'defaultValue' => ['a'],
                             'multiple' => true,
                             'typeItems' => [
                                 'a' => 'A',
                                 'b' => 'B',
                                 'c' => 'C',
                             ],
                         ],
                         'radioList' => [
                             'type' => 'radioList',
                             'defaultValue' => 'a',
                             'typeItems' => [
                                 'a' => 'A',
                                 'b' => 'B',
                                 'c' => 'C', 
                             ],
                         ],
                     ],
                ],
           ],
       ],
       'login' => [
           'tab' => 'admin',
           'fieldsets' => [
               'captcha' => [
                   'label' =>'Captcha code',
                   'fields' => [
                       'enabled' => [
                           'label' => 'Login captcha enabled',
                           'type' => 'select',
                           'defaultValue' => 1,
                           'typeItems' => [
                               0 => 'Disabled',
                               1 => 'When login failed',
                               2 => 'Enabled',
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
                             'typeItems' => [
                                 0 => 'Disabled',
                                 1 => 'Enabled',
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
       ],
    ],
];