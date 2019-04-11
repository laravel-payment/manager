<?php


namespace LaravelPayment\Manager\Payment;

use LaravelPayment\Manager\Payment\Results\ProcessResult;
use LaravelPayment\Manager\Payment\Results\StatusResult;
use LaravelPayment\Manager\Support\ProviderAbstract as BaseProviderAbstract;

abstract class ProviderAbstract extends BaseProviderAbstract
{

    const ROUTE_CHECK = 'check';
    const ROUTE_CALLBACK = 'callback';

    /**
     * Redirect to payment form
     *
     * @param $orderNumber
     * @param $currency
     * @param $amount
     * @return ProcessResult
     */
    abstract public function process($orderNumber, $currency, $amount): ProcessResult;

    abstract public function status($data): StatusResult;

    public function getRouteCheck()
    {
        return route(config('payment.route.as') . self::ROUTE_CHECK, ['provider' => $this->getName()]);
    }

    public function getRouteCallback()
    {
        return route(config('payment.route.as') . self::ROUTE_CALLBACK, ['provider' => $this->getName()]);
    }
}
