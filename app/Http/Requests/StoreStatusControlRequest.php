<?php

namespace App\Http\Requests;

use App\Models\StatusControl;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreStatusControlRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('status_control_create');
    }

    public function rules()
    {
        return [
            'status'      => [
                'string',
                'required',
            ],
            'desctiption' => [
                'string',
                'required',
            ],
        ];
    }
}
