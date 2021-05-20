<?php

namespace App\Http\Requests;

use App\Models\Gateway;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreGatewayRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('gateway_create');
    }

    public function rules()
    {
        return [
            'name'        => [
                'string',
                'required',
            ],
            'last_active' => [
                'string',
                'nullable',
            ],
            'guard'       => [
                'string',
                'required',
            ],
        ];
    }
}
