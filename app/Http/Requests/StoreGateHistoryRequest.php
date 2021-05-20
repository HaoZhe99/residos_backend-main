<?php

namespace App\Http\Requests;

use App\Models\GateHistory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreGateHistoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('gate_history_create');
    }

    public function rules()
    {
        return [
            'gate_code'   => [
                'string',
                'required',
            ],
            'type'        => [
                'string',
                'required',
            ],
            'username_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
