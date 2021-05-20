<?php

namespace App\Http\Requests;

use App\Models\FacilityCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFacilityCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('facility_category_edit');
    }

    public function rules()
    {
        return [
            'category' => [
                'string',
                'required',
            ],
        ];
    }
}
