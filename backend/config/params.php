<?php
return [
    'adminEmail' => 'admin@example.com',
    'nav'   => [
        'operator'     => [
            '_menu' => [
                'label'     => 'Operator',
                'linkOptions' => []
            ],
            'index'  => [
                '_menu' => [
                    'label'     => 'Dashboard',
                    'url'       => '/operator',
                ]
            ],
            '_divider'  => true,
            'ask'  => [
                '_menu' => [
                    'label'     => 'Asks',
                    'url'       => '/ask'
                ]
            ],
            'ticket'  => [
                '_menu' => [
                    'label'     => 'Tickets',
                    'url'       => '/ticket'
                ]
            ],
            'member'  => [
                '_menu' => [
                    'label'     => 'Members',
                    'url'       => '/member'
                ]
            ],
            'party'  => [
                '_menu' => [
                    'label'     => 'Parties',
                    'url'       => '/party'
                ]
            ]
        ],
        'manager' => [
            '_menu' => [
                'label'     => 'Manager',
                'linkOptions' => []
            ],
            'price'  => [
                '_menu' => [
                    'label'     => 'Prices',
                    'url'       => '/price'
                ]
            ],
            'place'  => [
                '_menu' => [
                    'label'     => 'Places',
                    'url'       => '/place'
                ]
            ],
            'group'  => [
                '_menu' => [
                    'label'     => 'Groups',
                    'url'       => '/group'
                ]
            ],
            'media' => [
                '_menu' => [
                    'label' => 'Media',
                    'url'   => '/media'
                ]
            ]
        ],
        'admin' => [
                '_menu' => [
                    'label' => 'Admin'
                ],
                'setting' => [
                    '_menu' => [
                        'label' => 'Settings',
                        'url'   => '/setting'
                    ]
                ],
                'control' => [
                    '_menu' => [
                        'label' => 'Control',
                        'url'   => '/user/admin'
                    ]
                ]
            ]
    ]
];
