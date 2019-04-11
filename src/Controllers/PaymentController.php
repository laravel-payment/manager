<?php


namespace LaravelPayment\Manager\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LaravelPayment\Manager\Models\Payment as PaymentModel;
use LaravelPayment\Manager\Models\PaymentLog as PaymentLogModel;
use LaravelPayment\Manager\Requests\PaymentProcessRequest;
use LaravelPayment\Manager\Facades\Payment;

class PaymentController extends BaseController
{
    public function callback($provider)
    {
        dd($provider);
    }

    public function process(PaymentProcessRequest $request, $provider)
    {
        return DB::transaction(function () use ($request, $provider) {
            /** @var \Illuminate\Foundation\Auth\User|null $user */
            $user = Auth::user();

            $paymentProvider = Payment::driver($provider);

            /** @var PaymentModel $paymentModel */
            $paymentModel = new PaymentModel([
                'provider' => $provider,
                'currency' => $request->get('currency'),
                'amount'   => $request->get('amount'),
                'status'   => PaymentModel::STATUS_NEW,
            ]);

            $paymentModel->user()->associate($user);
            $paymentModel->save();

            $result = $paymentProvider->process(
                $paymentModel->id,
                $request->get('currency'),
                $request->get('amount')
            );

            $paymentModel->provider_order_id = $result->providerOrderId;
            $paymentModel->save();

            return redirect()->to($result->redirectUrl);
        }, 5);
    }

    public function fail(Request $request, $provider)
    {
        $paymentProvider = Payment::driver($provider);

        $paymentProvider->status($request->get('orderId'));
    }

    public function check(Request $request, $provider)
    {
        return DB::transaction(function () use ($request, $provider) {
            $paymentProvider = Payment::driver($provider);

            $status = $paymentProvider->status($request->all());

            /** @var PaymentModel $paymentModel */
            $paymentModel = PaymentModel::query()
                ->where('provider', $provider)
                ->where('provider_order_id', $status->providerOrderId)
                ->first();


            if ($paymentModel->status !== $status->status) {
                $paymentModel->status = $status->status;
                $paymentModel->logs()->create([
                    'response' => $status->response,
                ]);

                $paymentModel->save();
            }

            switch ($status->status) {
                case PaymentModel::STATUS_NEW:
                case PaymentModel::STATUS_PROCESS:
                    return view('laravel-payment:check');
                case PaymentModel::STATUS_PRE_AUTH_SUM:
                case PaymentModel::STATUS_SUCCESS:
                    return redirect(config('payment.url.success'));
                case PaymentModel::STATUS_CANCEL:
                case PaymentModel::STATUS_DECLINE:
                    return redirect(config('payment.url.fail'));
                default:
                    return redirect(config('payment.url.fail'));
            }

        }, 5);
    }


}
