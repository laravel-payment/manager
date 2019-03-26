<?php


namespace LaravelPayment\Manager\Facades;


use Illuminate\Support\Facades\Facade;
use LaravelPayment\Manager\Contracts\Payment\Factory;

class Payment extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}
