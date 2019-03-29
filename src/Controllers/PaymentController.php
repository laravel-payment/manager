<?php


namespace LaravelPayment\Manager\Controllers;

use Illuminate\Routing\Controller as BaseController;

class PaymentController extends BaseController
{
    public function callback($provider)
    {
        dd($provider);
    }

    public function process($provider)
    {
        dd(app(\LaravelPayment\Manager\Facades\Payment::class));
//        return \Payment::driver($provider)->process();
    }
}
