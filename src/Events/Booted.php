<?php


namespace Mxp100\LaravelPayment\Events;

use Illuminate\Contracts\Container\Container as Application;

class Booted
{

    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
}
