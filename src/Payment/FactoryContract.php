<?php


namespace LaravelPayment\Manager\Payment;


interface FactoryContract
{
    /**
     * Get an payment provider implementation.
     *
     * @param  string  $driver
     * @return ProviderAbstract
     */
    public function driver($driver = null);
}
