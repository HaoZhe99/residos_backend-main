<?php

namespace App\Http\Requests;

use App\Models\AddUnit;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAddUnitRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('add_unit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:add_units,id',
        ];
    }
}
