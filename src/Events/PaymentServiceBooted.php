<?php


namespace LaravelPayment\Manager\Events;

use Illuminate\Contracts\Container\Container as Application;
use Illuminate\Foundation\Events\Dispatchable;
use LaravelPayment\Manager\Payment\FactoryContract as PaymentFactory;
use LaravelPayment\Manager\Payout\FactoryContract as PayoutFactory;
use LaravelPayment\Manager\Payment\ProviderContract as PaymentProviderContract;
use LaravelPayment\Manager\Payout\ProviderContract as PayoutProviderContract;
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


        $this->getManager($providerClass)
            ->extend($providerName, function () use ($providerName, $providerClass) {
                return $this
                    ->createProvider($providerClass, config('payment.services.' . $providerName))
                    ->setClient(new RequestClient());
            });
    }

    /**
     * @param string $providerClass
     * @return ProviderAbstract
     */
    private function createProvider($providerClass, $config): ProviderAbstract
    {
        if (!class_exists($providerClass)) {
            throw new InvalidArgumentException($providerClass . ' not exist');
        }

        return new $providerClass($config);
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
            return $this->app->make(PayoutFactory::class);
        }

        throw new InvalidProviderException('invalid provider');
    }
}
