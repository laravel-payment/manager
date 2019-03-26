<?php


namespace LaravelPayment\Manager;


use Illuminate\Support\Manager;

class PayoutManager extends Manager implements Contracts\Payout\Factory
{

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        throw new \InvalidArgumentException('No payout driver was specified.');
    }
}
