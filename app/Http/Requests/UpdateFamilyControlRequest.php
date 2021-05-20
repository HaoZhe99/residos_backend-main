<?php

namespace App\Http\Requests;

use App\Models\FamilyControl;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFamilyControlRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('family_control_edit');
    }

    public function rules()
    {
        return [
            'family_id'     => [
                'required',
                'integer',
            ],
            'unit_owner_id' => [
                'required',
                'integer',
            ],
            'activity_logs' => [
                'required',
            ],
        ];
    }
}
