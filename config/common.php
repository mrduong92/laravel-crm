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
    ],
    'knowledge' => [
        'mime_types' => [
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // xlsx
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // docx
            'pdf' => 'application/pdf', // pdf
            'txt' => 'text/plain', // txt
            'csv' => 'text/csv', // csv
        ]
    ]
];
