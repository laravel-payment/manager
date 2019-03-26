<?php


namespace Mxp100\LaravelPayment\Facades;


use Illuminate\Support\Facades\Facade;
use Mxp100\LaravelPayment\Contracts\Payment\Factory;

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
