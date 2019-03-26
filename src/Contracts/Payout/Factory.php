<?php


namespace Mxp100\LaravelPayment\Contracts\Payout;


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
