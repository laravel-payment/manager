<?php


namespace LaravelPayment\Manager\Events;

use Illuminate\Contracts\Container\Container as Application;
use Illuminate\Foundation\Events\Dispatchable;
use LaravelPayment\Manager\Payment\FactoryContract as PaymentFactory;
use LaravelPayment\Manager\Payout\FactoryContract as PayoutFactory;
use LaravelPayment\Manager\Payment\ProviderAbstract as PaymentProviderAbstract;
use LaravelPayment\Manager\Payout\ProviderAbstract as PayoutProviderAbstract;
use LaravelPayment\Manager\Exceptions\InvalidArgumentException;
use LaravelPayment\Manager\Exceptions\InvalidProviderException;
use LaravelPayment\Manager\Payment\Manager as PaymentManager;
use LaravelPayment\Manager\Payout\Manager as PayoutManager;
use LaravelPayment\Manager\Support\ProviderAbstract;
use LaravelPayment\Manager\Support\RequestClient;

class PaymentServiceBooted
{
    use Dispatchable;

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
        $provider = $this
            ->createProvider($providerName, $providerClass)
            ->setClient(new RequestClient());

        $provider->boot();

        $this->getManager($provider)
            ->extend($providerName, function () use ($provider) {
                return $provider;
            });
    }

    /**
     * @param string $providerName
     * @param string $providerClass
     *
     * @return ProviderAbstract
     */
    private function createProvider($providerName, $providerClass): ProviderAbstract
    {
        if (!class_exists($providerClass)) {
            throw new InvalidArgumentException($providerClass . ' not exist');
        }

        return new $providerClass($providerName, config('payment.services.' . $providerName));
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
        if ($provider instanceof PaymentProviderAbstract) {
            return $this->app->make(PaymentFactory::class);
        }

        if ($provider instanceof PayoutProviderAbstract) {
            return $this->app->make(PayoutFactory::class);
        }

        throw new InvalidProviderException('invalid provider');
    }
}
