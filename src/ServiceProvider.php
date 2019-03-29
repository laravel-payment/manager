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

        event($paymentServiceBooted);

        $this->registerRoutes();
    }

    public function when()
    {
        return [
            'bootstrapped: Illuminate\Foundation\Bootstrap\BootProviders'
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

    public function registerPublish()
    {
        $this->publishes([
            __DIR__ . '/../config/payment.php' => config_path('payment.php'),
        ]);
    }

    public function registerRoutes()
    {
        $routeConfig = $this->app['config']->get('payment.route') +
            [
                'namespace' => __NAMESPACE__ . '\\Controllers',
            ];

        $this->getRouter()->group($routeConfig, function ($router) {
            /** @var Router $router */

            $router->addRoute(['GET', 'POST'], '{provider}/callback', 'PaymentController@callback')->name('callback');
            $router->get('{provider}', 'PaymentController@process')->name('process');


        });
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

}
