<?php

namespace App\Http\Requests;

use App\Models\TenantControl;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTenantControlRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('tenant_control_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:tenant_controls,id',
        ];
    }
}
