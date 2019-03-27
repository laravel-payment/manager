<?php


namespace LaravelPayment\Manager\Events;

use Illuminate\Contracts\Container\Container as Application;
use LaravelPayment\Manager\Contracts\Payment\Factory as PaymentFactory;
use LaravelPayment\Manager\Contracts\Payment\Provider as PaymentProviderContract;
use LaravelPayment\Manager\Contracts\Payout\Provider as PayoutProviderContract;
use LaravelPayment\Manager\Exceptions\InvalidArgumentException;
use LaravelPayment\Manager\Exceptions\InvalidProviderException;
use LaravelPayment\Manager\PaymentManager;
use LaravelPayment\Manager\PayoutManager;

class PaymentServiceBooted
{

    protected $app;

    /**
     * PaymentBooted constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function extendService($providerName, $providerClass)
    {


        $provider = $this->createProvider($providerClass);

        $manager = $this->getManager($provider);

        $manager->extend($providerName, function () use ($provider) {
            return new $provider();
        });
    }

    private function createProvider($providerClass)
    {
        if (!class_exists($providerClass)) {
            throw new InvalidArgumentException($providerClass . ' not exist');
        }

        return new $providerClass;
    }

    /**
     * Get manager
     *
     * @param $provider
     * @return PaymentManager|PayoutManager
     * @throws InvalidProviderException
     */
    private function getManager($provider)
    {
        if ($provider instanceof PaymentProviderContract) {
            return $this->app->make(PaymentFactory::class);
        }

        if ($provider instanceof PayoutProviderContract) {
            return $this->app->make(PaymentFactory::class);
        }

        throw new InvalidProviderException('invalid provider');
    }
}
