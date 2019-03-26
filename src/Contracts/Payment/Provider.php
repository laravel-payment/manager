<?php


namespace LaravelPayment\Manager\Contracts\Payment;


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
