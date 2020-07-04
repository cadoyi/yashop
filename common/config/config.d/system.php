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
                              'defaultValue' => 'My website',
                              'validators' => [
                                  ['required'],
                                  ['string', 'max' => 255],
                              ],
                         ],
                    ],
                ],
           ],
       ],
    ],
];