<?php

namespace App\Http\Requests;

use App\Models\GateHistory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyGateHistoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('gate_history_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:gate_histories,id',
        ];
    }
}
