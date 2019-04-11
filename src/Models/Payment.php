<?php

namespace LaravelPayment\Manager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

/**
 * Class Payment
 *
 * @property integer    $id
 * @property string     $provider
 * @property string     $provider_order_id
 * @property string     $provider_status
 * @property integer    $currency
 * @property float      $amount
 * @property integer    $status
 *
 * @property User       $user
 * @property PaymentLog $logs
 *
 * @package LaravelPayment\Manager\Models
 */
class Payment extends Model
{

    const STATUS_NEW = 0;
    const STATUS_PROCESS = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_CANCEL = 3;
    const STATUS_DECLINE = 4;
    const STATUS_REFUND = 5;
    const STATUS_PRE_AUTH_SUM = 6;

    protected $fillable = [
        'provider',
        'provider_order_id',
        'currency',
        'amount',
        'status',
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('payment.table_prefix') . 'payments';

        parent::__construct($attributes);
    }

    public function user()
    {
        return $this->morphTo('user', 'user_type', 'user_id');
    }

    public function logs()
    {
        return $this->hasMany(PaymentLog::class, 'payment_id', 'id');
    }
}
