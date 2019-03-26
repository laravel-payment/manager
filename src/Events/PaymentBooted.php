<?php


namespace LaravelPayment\Manager\Events;

use Illuminate\Contracts\Container\Container as Application;
use LaravelPayment\Manager\Contracts\Payment\Factory as PaymentFactory;
use LaravelPayment\Manager\Exceptions\InvalidArgumentException;
use LaravelPayment\Manager\PaymentManager;

class PaymentBooted
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

    public function extendPayment($providerName, $providerClass)
    {
        /** @var PaymentManager $manager */
        $manager = $this->app->make(PaymentFactory::class);

        $this->providerExists($providerClass);

        $manager->extend($providerName, function () use ($manager, $providerName, $providerClass) {
            $provider = $this->buildProvider($manager, $providerName, $providerClass);
        });
    }

    protected function buildProvider(PaymentManager $manager, $providerName, $providerClass)
    {

    }

    private function providerExists($providerClass)
    {
        if (!class_exists($providerClass)) {
            throw new InvalidArgumentException($providerClass . ' not exist');
        }
    }
}
