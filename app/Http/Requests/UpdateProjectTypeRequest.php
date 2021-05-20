<?php

namespace App\Http\Requests;

use App\Models\ProjectType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateProjectTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('project_type_edit');
    }

    public function rules()
    {
        return [
            'category_id' => [
                'required',
                'integer',
            ],
            'type'        => [
                'string',
                'required',
            ],
        ];
    }
}
