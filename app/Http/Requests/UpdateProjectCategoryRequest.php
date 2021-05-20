<?php

namespace App\Http\Requests;

use App\Models\ProjectCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateProjectCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('project_category_edit');
    }

    public function rules()
    {
        return [
            'project_category' => [
                'string',
                'required',
            ],
        ];
    }
}
