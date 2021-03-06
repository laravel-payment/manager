<?php


namespace LaravelPayment\Manager\Facades;


use Illuminate\Support\Facades\Facade;
use LaravelPayment\Manager\Payout\FactoryContract;

class Payout extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return FactoryContract::class;
    }
}
