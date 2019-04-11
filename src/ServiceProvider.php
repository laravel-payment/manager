<?php

namespace LaravelPayment\Manager;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use LaravelPayment\Manager\Events\PaymentServiceBooted;

class ServiceProvider extends BaseServiceProvider
{

    protected $defer = true;

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublish();
        }

        $paymentServiceBooted = app(PaymentServiceBooted::class);

        $this->app->booted(function(){
            $this->registerRoutes();
        });

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-payment');

        event($paymentServiceBooted);
    }

    public function when()
    {
        return [
            'bootstrapped: Illuminate\Foundation\Bootstrap\BootProviders',
        ];
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Payment\FactoryContract::class, function ($app) {
            return new Payment\Manager($app);
        });

        $this->app->singleton(Payout\FactoryContract::class, function ($app) {
            return new Payout\Manager($app);
        });

        $configPath = __DIR__ . '/../config/payment.php';
        $this->mergeConfigFrom($configPath, 'payment');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Payment\FactoryContract::class,
            Payout\FactoryContract::class,
        ];
    }

    /**
     * Get router
     *
     * @return \Illuminate\Routing\Router
     */
    protected function getRouter()
    {
        return $this->app['router'];
    }

    protected function registerPublish()
    {
        $this->publishes([
            __DIR__ . '/../config/payment.php' => config_path('payment.php'),
            __DIR__ . '/../resources/views'    => resource_path('views/vendor/laravel-payment'),
        ]);
    }

    protected function registerRoutes()
    {
        $routeConfig = config('payment.route') +
            [
                'namespace' => __NAMESPACE__ . '\\Controllers',
            ];


        $this->getRouter()->group($routeConfig, function (&$router) {
            /** @var Router $router */

            $router->addRoute(['GET', 'POST'], '{provider}/callback', [
                'uses' => 'PaymentController@callback',
                'as'   => 'callback',
            ]);

            $router->get('{provider}/check', [
                'uses' => 'PaymentController@check',
                'as'   => 'check',
            ]);

            $router->get('{provider}', [
                'uses' => 'PaymentController@process',
                'as'   => 'process',
            ]);
        });
    }
}
