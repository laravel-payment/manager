<?php


namespace LaravelPayment\Manager\Requests;


use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PaymentProcessRequest
 *
 * @package LaravelPayment\Manager\Requests
 */
class PaymentProcessRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount'   => 'required|numeric',
            'currency' => 'required',
        ];
    }
}
