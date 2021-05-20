<?php

namespace App\Http\Requests;

use App\Models\Transaction;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTransactionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('transaction_create');
    }

    public function rules()
    {
        return [
            'bill_code'   => [
                'string',
                'required',
            ],
            'credit'      => [
                'string',
                'nullable',
            ],
            'debit'       => [
                'string',
                'nullable',
            ],
            'username_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
