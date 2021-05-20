<?php

namespace App\Http\Requests;

use App\Models\BankName;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBankNameRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('bank_name_create');
    }

    public function rules()
    {
        return [
            'country'    => [
                'string',
                'required',
            ],
            'bank_name'  => [
                'string',
                'required',
            ],
            'swift_code' => [
                'string',
                'nullable',
            ],
            'bank_code'  => [
                'string',
                'nullable',
            ],
        ];
    }
}
