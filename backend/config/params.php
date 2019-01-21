<?php
return [
    'adminEmail' => 'admin@example.com',
    'nav'   => [
        'admin'     => [
            '_menu' => [
                'label'     => 'Admin',
                'linkOptions' => []
            ],
            'index' => [
                '_menu' => [
                    'label' => 'Panel',
                    'url'   => '/admin'
                ]
            ],
            'control' => [
                '_menu' => [
                    'label' => 'Control',
                    'url'   => '/user/admin'
                ]
            ],
            'ask'  => [
                '_menu' => [
                    'label'     => 'Asks',
                    'url'       => '/ask'
                ]
            ],
            'party'  => [
                '_menu' => [
                    'label'     => 'Parties',
                    'url'       => '/party'
                ]
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
            'member'  => [
                '_menu' => [
                    'label'     => 'Members',
                    'url'       => '/member'
                ]
            ]
        ],
        'manager'   => [
            '_menu' => [
                'label'     => 'Manager',
                'linkOptions' => []
            ],
            'index' => [
                '_menu' => [
                    'label' => 'Panel',
                    'url'   => 'manager'
                ]
            ],
            'ask'  => [
                '_menu' => [
                    'label'     => 'Asks',
                    'url'       => 'manager/ask'
                ]
            ],
            'party'  => [
                '_menu' => [
                    'label'     => 'Parties',
                    'url'       => 'manager/party'
                ]
            ],
            'price'  => [
                '_menu' => [
                    'label'     => 'Prices',
                    'url'       => 'manager/price'
                ]
            ],
            'place'  => [
                '_menu' => [
                    'label'     => 'Places',
                    'url'       => 'manager/place'
                ]
            ],
            'member'  => [
                '_menu' => [
                    'label'     => 'Members',
                    'url'       => 'manager/member'
                ]
            ]
        ],
        'operator'  => [
            '_menu' => [
                'label'     => 'Operator',
                'linkOptions' => []
            ],
            'index' => [
                '_menu' => [
                    'label' => 'Panel',
                    'url'   => '/operator'
                ]
            ],
            'ask'  => [
                '_menu' => [
                    'label'     => 'Asks',
                    'url'       => '/operator/ask'
                ]
            ],
            'party'  => [
                '_menu' => [
                    'label'     => 'Parties',
                    'url'       => '/operator/party'
                ]
            ],
            'price'  => [
                '_menu' => [
                    'label'     => 'Prices',
                    'url'       => '/operator/price'
                ]
            ],
            'place'  => [
                '_menu' => [
                    'label'     => 'Places',
                    'url'       => '/operator/place'
                ]
            ],
            'member'  => [
                '_menu' => [
                    'label'     => 'Members',
                    'url'       => '/operator/member'
                ]
            ]
        ]
    ]
];
