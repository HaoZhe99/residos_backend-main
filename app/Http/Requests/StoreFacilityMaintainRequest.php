<?php

namespace App\Http\Requests;

use App\Models\FacilityMaintain;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFacilityMaintainRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('facility_maintain_create');
    }

    public function rules()
    {
        return [
            'username_id'      => [
                'required',
                'integer',
            ],
            'facility_code_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
