<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/currency'  ], function (Router $router) {
    $router->get('/switch/{currencyCode}', [
        'as' => 'currency.switch',
        'uses' => 'ApiController@switchCurrency'
        //'middleware' => 'can:currency.currencies.index'
    ]);
});