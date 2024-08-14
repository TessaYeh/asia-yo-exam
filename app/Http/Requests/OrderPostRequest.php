<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Constants\OrderConstant;

class OrderPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => [
                'required',
                'string',
            ],
            'name' => [
                'required',
                'string',
            ],
            'address.city' => [
                'required',
                'string',
            ],
            'address.district' => [
                'required',
                'string',
            ],
            'address.street' => [
                'required',
                'string',
            ],
            'price' => [
                'required',
                'string',
            ],
            'currency' => [
                'required',
                Rule::in(['TWD', 'USD']),
            ],
        ];
    }

    // protected function withValidator($validator)
    // {
    //     $validator->after(function ($validator) {
    //         $name = $this->input('name');
    //         if (isset($name) && !preg_match('/^[a-zA-Z]+$/', $name)) {
    //             $validator->errors()->add('name', 'Name contains non-English characters');
    //         } elseif (isset($name) && !preg_match('/^[A-Z]/', $name)) {
    //             $validator->errors()->add('name', 'Name is not capitalized');
    //         }
    //     });
    // }

    // protected function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json([
    //         'message' => 'The given data was invalid',
    //         'errors'  => $validator->errors(),
    //     ], 400));
    // }

    // protected function prepareForValidation()
    // {
    //     if ($this->input('currency') != OrderConstant::CURRENCY_TWD) {
    //         $this->merge([
    //             'price' => $this->input('price') * OrderConstant::CURRENCY_EXCHANGE_RATES[$this->input('currency')],
    //             'currency' => OrderConstant::CURRENCY_TWD,
    //         ]);
    //     }
    // }
}
