<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/currency'], function (Router $router) {
    $router->bind('currency', function ($id) {
        return app('Modules\Currency\Repositories\CurrencyRepository')->find($id);
    });
    $router->get('currencies', [
        'as' => 'admin.currency.currency.index',
        'uses' => 'CurrencyController@index',
        'middleware' => 'can:currency.currencies.index'
    ]);
    $router->get('currencies/create', [
        'as' => 'admin.currency.currency.create',
        'uses' => 'CurrencyController@create',
        'middleware' => 'can:currency.currencies.create'
    ]);
    $router->post('currencies', [
        'as' => 'admin.currency.currency.store',
        'uses' => 'CurrencyController@store',
        'middleware' => 'can:currency.currencies.create'
    ]);
    $router->get('currencies/{currency}/edit', [
        'as' => 'admin.currency.currency.edit',
        'uses' => 'CurrencyController@edit',
        'middleware' => 'can:currency.currencies.edit'
    ]);
    $router->post('currencies/{currency}', [
        'as' => 'admin.currency.currency.update',
        'uses' => 'CurrencyController@update',
        'middleware' => 'can:currency.currencies.edit'
    ]);
    $router->delete('currencies/{currency}', [
        'as' => 'admin.currency.currency.destroy',
        'uses' => 'CurrencyController@destroy',
        'middleware' => 'can:currency.currencies.destroy'
    ]);
});
