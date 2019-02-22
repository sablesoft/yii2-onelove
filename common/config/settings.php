<?php
return [
    'domain' => [
        'front' => "$scheme://$domain",
        'back'  => "$scheme://admin.$domain"
    ],
    // used in Party->getCurrentPhone()
    'defaultPhone' => '375296092441',
    'operators' => ['25', '29', '33', '44' ],
    // age default params:
    'age' => [
        'min' => 16,
        'max' => 70
    ],
    'owner' => 'ИП Лебедкина Ирина Владимировна УНП №191781611',
    'email' => [
        'default'   => [
            'noreply@onelove.by'    => 'OneLove CRM'
        ],
        'dev'       => [
            'dev@onelove.by'        => 'OneLove Dev'
        ],
        'admin'     => [
            'admin@onelove.by'      => 'OneLove Admin'
        ],
        'manager'  => [
            'manager@onelove.by'   => 'OneLove Manager'
        ],
        'operator'  => [
            'operator@onelove.by'   => 'OneLove Operator'
        ]
    ],
    'members' => [
        'delta' => 5,
        'count' => 15
    ],
    'modal' => [
        'success' => [
            'header'    => 'Ask sent',
            'message'   => 'Our operator will contact you shortly.'
        ],
        'fail'  => [
            'header'    => 'Oops!',
            'message'   => 'Something went wrong. Please try later.'
        ]
    ],
    // country code default param: todo
    'countryCode' => '375',
    // social default params : todo
    'messenger'    => [
        'whatsapp' => [
            'class' => 'whatsapp',
            'label' => 'WhatsApp',
            'icon'  => 'fa-whatsapp'
        ],
        'telegram' => [
            'class' => 'telegram',
            'label' => 'Telegram',
            'icon'  => 'fa-telegram-plane'
        ],
        'viber' => [
            'class' => 'viber',
            'label' => 'Viber',
            'icon'  => 'fa-viber'
        ]
    ],
    'messengersConfig' => [
        'whatsapp'  => 'whatsapp://send?phone=+',
        'viber'     => [
            'mobile'    => 'viber://add?number=+',
            'desktop'   => 'viber://chat?number=+'
        ]
    ],
    // sections default params : todo
    'section' => [
        "gallery"   => false,
        "comments"  => false
    ],
    'groups' => [
        'от 22 до 34',
        'от 35 и старше'
    ],
    'keys'      => [
        [
            "text" => "Вы готовы к общению и открыты для новых знакомств и отношений?<br>Тогда приходите к нам. И за один вечер Вы сможете познакомиться с 10-15  интересными людьми противоположного пола и встретить свою половинку."
        ]
    ],
    'access' => [
        'skipController'    => ['site'],
        'skipModule'        => ['front', 'user'],
        'pattern' => [
            'back'   => "{controller}.{action}",
            'media'  => "{module}.{action}",
            'rbac'   => "{controller}.{action}",
            'gallery' => "{module}.{action}",
            'gii'    => "{module}"
        ]
    ]
];