# Laravel-payment Providers Manager

## Adding payment provider

## Creating a Handler

Below is an example handler.  You need to add this full class name to the `listen[]` in the `EventServiceProvider`.

* [See also the Laravel docs about events](http://laravel.com/docs/5.6/events).
* `providername` is the name of the provider such as `sberbank`.
* You will need to change your the namespacing and class names of course.  


```php
namespace Your\Name\Space;

use LaravelPayment\Manager\Events\PaymentServiceBooted;

class LaravelPaymentExtend
{
    public function handle(PaymentServiceBooted $paymentBooted)
    {
        $paymentBooted->extendService('[providername]', Provider::class);
    }
}
```
