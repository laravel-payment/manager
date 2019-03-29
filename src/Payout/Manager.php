<?php


namespace LaravelPayment\Manager\Payout;


use Illuminate\Support\Manager as BaseManager;

class Manager extends BaseManager implements FactoryContract
{

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        throw new \InvalidArgumentException('No payout driver was specified.');
    }
}
