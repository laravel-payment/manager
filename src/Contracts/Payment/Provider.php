<?php


namespace Mxp100\LaravelPayment\Contracts\Payment;


interface Provider
{
    /**
     * Redirect to payment form
     *
     * @return \Illuminate\Http\Response
     */
    public function process();

    public function result();
}
