<?php


namespace LaravelPayment\Manager\Payment;


use LaravelPayment\Manager\Payment\Results\CallbackResult;

abstract class WithCallbackProviderAbstract extends ProviderAbstract
{
    abstract public function callback($data): CallbackResult;
}
