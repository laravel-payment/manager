<?php


namespace LaravelPayment\Manager\Contracts\Payment;


interface Factory
{
    /**
     * Get an OAuth provider implementation.
     *
     * @param  string  $driver
     * @return Provider
     */
    public function driver($driver = null);
}
