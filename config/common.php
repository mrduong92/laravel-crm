<?php

return [
    'logo' => '',
    'super_role' => 'superadmin',
    'roles' => [
        'owner',
        'admin',
        'sales',
    ],
    'per_page' => 9,
    'statuses' => [
        'draft' => 0,
        'published' => 1,
    ],
    'posts' => [
        'status' => [
            'hide' => 0,
            'publish' => 1,
            'pending' => 2,
        ]
    ]
];
