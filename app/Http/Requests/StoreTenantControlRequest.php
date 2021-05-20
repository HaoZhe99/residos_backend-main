<?php

namespace App\Http\Requests;

use App\Models\TenantControl;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTenantControlRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('tenant_control_create');
    }

    public function rules()
    {
        return [
            'tenant_id'     => [
                'required',
                'integer',
            ],
            'status'        => [
                'required',
            ],
            'rent_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
