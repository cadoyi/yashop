<?php


return [
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
                 'keywords' => [
                     'type' => 'textarea',
                     'defaultValue' => 'website keywords',
                     'validators' => [
                          ['required'],
                          ['string'],
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
                 'icp' => [
                     'type' => 'text',
                     'defaultValue' => '京ICP 12345678',
                     'validators' => [
                         ['required'],
                         ['string', 'max' => 255],
                     ],
                 ],
             ],
        ],
   ],
];