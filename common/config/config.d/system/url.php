<?php

return [
    'tab' => 'general',
    'fieldsets' => [
        'frontend' => [
             'fields' => [
                  'base' => [
                      'label' => 'Base url',
                      'type'  => 'text',
                      'defaultValue' => 'http://www.yashop.cn',
                      'validators' => [
                          ['url'],
                      ],
                  ],
                  'secure' => [
                      'label' => 'Secure url',
                      'type'  => 'text',
                      'defaultValue' => 'http://www.yashop.cn',
                      'validators' => [
                          ['url'],
                      ],  
                  ],
             ],
        ],
        'backend' => [
             'fields' => [
                  'base' => [
                      'label' => 'Base url',
                      'type'  => 'text',
                      'defaultValue' => 'http://admin.yashop.cn',
                      'validators' => [
                          ['url'],
                      ],
                  ],
                  'secure' => [
                      'label' => 'Secure url',
                      'type'  => 'text',
                      'defaultValue' => 'http://admin.yashop.cn',
                      'validators' => [
                          ['url'],
                      ],  
                  ],
             ],
        ],
        'shop'  => [
             'fields' => [
                  'base' => [
                      'label' => 'Base url',
                      'type'  => 'text',
                      'defaultValue' => 'http://shop.yashop.cn',
                      'validators' => [
                          ['url'],
                      ],
                  ],
                  'secure' => [
                      'label' => 'Secure url',
                      'type'  => 'text',
                      'defaultValue' => 'http://shop.yashop.cn',
                      'validators' => [
                          ['url'],
                      ],  
                  ],
             ],
        ],
    ],
];