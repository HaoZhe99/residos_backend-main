<?php

namespace App\Http\Requests;

use App\Models\FeedbackListing;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFeedbackListingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('feedback_listing_edit');
    }

    public function rules()
    {
        return [
            'title'           => [
                'string',
                'required',
            ],
            'content'         => [
                'required',
            ],
            'send_to'         => [
                'string',
                'nullable',
            ],
            'reply'           => [
                'string',
                'nullable',
            ],
            'project_code_id' => [
                'required',
                'integer',
            ],
            'created_by_id'   => [
                'required',
                'integer',
            ],
        ];
    }
}
