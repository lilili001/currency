<?php

namespace Modules\Currency\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Currency\Events\Handlers\RegisterCurrencySidebar;

class CurrencyServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterCurrencySidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('currencies', array_dot(trans('currency::currencies')));
            $event->load('currencysymbols', array_dot(trans('currency::currencysymbols')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('currency', 'permissions');
        $this->publishConfig('currency', 'config');
        $this->publishConfig('currency', 'settings');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Currency\Repositories\CurrencyRepository',
            function () {
                $repository = new \Modules\Currency\Repositories\Eloquent\EloquentCurrencyRepository(new \Modules\Currency\Entities\CurrencyRate());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Currency\Repositories\Cache\CacheCurrencyDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Currency\Repositories\CurrencySymbolRepository',
            function () {
                $repository = new \Modules\Currency\Repositories\Eloquent\EloquentCurrencySymbolRepository(new \Modules\Currency\Entities\CurrencySymbol());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Currency\Repositories\Cache\CacheCurrencySymbolDecorator($repository);
            }
        );
// add bindings


    }
}
