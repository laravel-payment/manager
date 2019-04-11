<?php

namespace LaravelPayment\Manager\Models\Traits;

use LaravelPayment\Manager\Models\Payment;

trait Payments
{
    public function payments()
    {
        $this->morphOne(Payment::class, 'user', 'user_type', 'user_id');
    }
}
