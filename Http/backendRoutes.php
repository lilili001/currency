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
    $router->put('currencies/{currency}', [
        'as' => 'admin.currency.currency.update',
        'uses' => 'CurrencyController@update',
        'middleware' => 'can:currency.currencies.edit'
    ]);
    $router->delete('currencies/{currency}', [
        'as' => 'admin.currency.currency.destroy',
        'uses' => 'CurrencyController@destroy',
        'middleware' => 'can:currency.currencies.destroy'
    ]);
    /*************************** currencysymbol *********************************************/
    $router->bind('currencysymbol', function ($id) {
        return app('Modules\Currency\Repositories\CurrencySymbolRepository')->find($id);
    });
    $router->get('currencysymbols', [
        'as' => 'admin.currency.currencysymbol.index',
        'uses' => 'CurrencySymbolController@index',
        'middleware' => 'can:currency.currencysymbols.index'
    ]);
    $router->get('currencysymbols/create', [
        'as' => 'admin.currency.currencysymbol.create',
        'uses' => 'CurrencySymbolController@create',
        'middleware' => 'can:currency.currencysymbols.create'
    ]);
//    $router->post('currencysymbols', [
//        'as' => 'admin.currency.currencysymbol.store',
//        'uses' => 'CurrencySymbolController@store',
//        'middleware' => 'can:currency.currencysymbols.create'
//    ]);
//    $router->get('currencysymbols/{currencysymbol}/edit', [
//        'as' => 'admin.currency.currencysymbol.edit',
//        'uses' => 'CurrencySymbolController@edit',
//        'middleware' => 'can:currency.currencysymbols.edit'
//    ]);
    $router->post('currencysymbols', [
        'as' => 'admin.currency.currencysymbol.update',
        'uses' => 'CurrencySymbolController@update',
        //'middleware' => 'can:currency.currencysymbols.edit'
    ]);
//    $router->delete('currencysymbols/{currencysymbol}', [
//        'as' => 'admin.currency.currencysymbol.destroy',
//        'uses' => 'CurrencySymbolController@destroy',
//        'middleware' => 'can:currency.currencysymbols.destroy'
//    ]);
// append


});
