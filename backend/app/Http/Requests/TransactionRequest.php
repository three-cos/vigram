<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'wallet_id' => [
                'required',
                'integer',
            ],
            'type' => [
                'required',
                'string'
            ],
            'amount' => [
                'required',
                'numeric',
            ],
            'currency' => [
                'required',
                'string',
            ],
            'reason' => [
                'required',
                'string',
            ],
        ];
    }
}
