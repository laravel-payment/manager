<?php

namespace Mxp100\LaravelPayment;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Contracts\Payment\Factory::class, function ($app) {
            return new PaymentManager($app);
        });

        $this->app->singleton(Contracts\Payout\Factory::class, function ($app) {
            return new PayoutManager($app);
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
            Contracts\Payment\Factory::class,
            Contracts\Payout\Factory::class,
        ];
    }
}
