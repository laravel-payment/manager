<?php

namespace LaravelPayment\Manager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

/**
 * Class Payment
 *
 * @property integer $id
 * @property integer $payment_id
 * @property array   $response
 *
 * @package LaravelPayment\Manager\Models
 */
class PaymentLog extends Model
{

    protected $fillable = [
        'payment_id',
        'response',
    ];

    protected $casts = [
        'response' => 'json',
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('payment.table_prefix') . 'payment_logs';

        parent::__construct($attributes);
    }

}
