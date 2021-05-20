<?php

namespace App\Http\Requests;

use App\Models\DefectCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDefectCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('defect_category_edit');
    }

    public function rules()
    {
        return [
            'defect_cateogry' => [
                'string',
                'required',
            ],
            'in_enable'       => [
                'required',
            ],
        ];
    }
}
