<?php

namespace LaravelPayment\Manager;

use LaravelPayment\Manager\Events\PaymentBooted;
use LaravelPayment\Manager\Events\PayoutBooted;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $paymentBooted = app(PaymentBooted::class);
        $payoutBooted = app(PayoutBooted::class);

        event($paymentBooted);
        event($payoutBooted);
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
