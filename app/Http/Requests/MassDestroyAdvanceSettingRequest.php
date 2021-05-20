<?php

namespace App\Http\Requests;

use App\Models\AdvanceSetting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAdvanceSettingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('advance_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:advance_settings,id',
        ];
    }
}
