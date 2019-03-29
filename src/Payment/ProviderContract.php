<?php


namespace LaravelPayment\Manager\Payment;


interface ProviderContract
{
    /**
     * Redirect to payment form
     *
     * @return \Illuminate\Http\Response
     */
    public function process();

    public function callback();

    public function success();

    public function fail();
}
