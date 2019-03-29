<?php


namespace LaravelPayment\Manager\Facades;


use Illuminate\Support\Facades\Facade;
use LaravelPayment\Manager\Payment\FactoryContract;

class Payment extends Facade
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
