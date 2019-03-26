<?php


namespace Mxp100\LaravelPayment\Facades;


use Illuminate\Support\Facades\Facade;
use Mxp100\LaravelPayment\Contracts\Payout\Factory;

class Payout extends Facade
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
