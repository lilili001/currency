<?php

return [
    'default-currency' =>[
        'description' => 'Default Currency',
        'view' => 'text',
        'default' => 'USD'
    ],
    'allowed-currencies' => [
        'description' => 'Allowed Currencies',
        'view' => 'currency::fields.select',
    ],
];
