<?php


namespace LaravelPayment\Manager;


use Illuminate\Support\Manager;

class PaymentManager extends Manager implements Contracts\Payment\Factory
{

    public function with($driver){
        return $this->driver($driver);
    }

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
