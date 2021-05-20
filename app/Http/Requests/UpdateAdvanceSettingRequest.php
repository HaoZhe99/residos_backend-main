<?php

namespace App\Http\Requests;

use App\Models\AdvanceSetting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAdvanceSettingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('advance_setting_edit');
    }

    public function rules()
    {
        return [
            'key'          => [
                'string',
                'nullable',
            ],
            'status'       => [
                'string',
                'nullable',
            ],
            'project_code' => [
                'string',
                'nullable',
            ],
            'amount'       => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
