<?php


namespace LaravelPayment\Manager\Payout;


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
