<?php

namespace App\Http\Requests;

use App\Models\Qr;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateQrRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('qr_edit');
    }

    public function rules()
    {
        return [
            'code'            => [
                'string',
                'required',
            ],
            'status'          => [
                'string',
                'required',
            ],
            'type'            => [
                'string',
                'nullable',
            ],
            'expired_at'      => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'project_code_id' => [
                'required',
                'integer',
            ],
            'unit_owner_id'      => [
                'string',
                'nullable',
            ],
        ];
    }
}
