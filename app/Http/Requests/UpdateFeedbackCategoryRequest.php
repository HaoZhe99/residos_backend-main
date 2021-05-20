<?php

namespace App\Http\Requests;

use App\Models\FeedbackCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFeedbackCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('feedback_category_edit');
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
