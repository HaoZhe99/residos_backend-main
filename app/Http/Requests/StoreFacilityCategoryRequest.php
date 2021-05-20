<?php

namespace App\Http\Requests;

use App\Models\FacilityCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFacilityCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('facility_category_create');
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
