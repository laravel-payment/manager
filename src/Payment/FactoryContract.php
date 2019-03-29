<?php


namespace LaravelPayment\Manager\Payment;


interface FactoryContract
{
    /**
     * Get an OAuth provider implementation.
     *
     * @param  string  $driver
     * @return ProviderContract
     */
    public function driver($driver = null);
}
