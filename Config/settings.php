<?php

return [
    'default-currency' =>[
        'description' => 'Default Currency',
        'view' => 'text',
        'default' => 'USD'
    ],
    'current-currency' => [
        'description' => 'Current Currency',
        'view' => 'currency::fields.selectsingle',
        'default' => 'USD'
    ],
    'allowed-currencies' => [
        'description' => 'Allowed Currencies',
        'view' => 'currency::fields.select',
    ],
];
