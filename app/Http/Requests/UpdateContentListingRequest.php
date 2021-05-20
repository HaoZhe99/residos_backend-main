<?php

namespace App\Http\Requests;

use App\Models\ContentListing;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateContentListingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('content_listing_edit');
    }

    public function rules()
    {
        return [
            'type_id'         => [
                'required',
                'integer',
            ],
            'title'           => [
                'string',
                'required',
            ],
            'description'     => [
                'string',
                'required',
            ],
            'language'        => [
                'string',
                'required',
            ],
            'created_by'      => [
                'string',
                'nullable',
            ],
            'send_to'         => [
                'string',
                'nullable',
            ],
            'url'             => [
                'string',
                'nullable',
            ],
            'user_group'      => [
                'string',
                'nullable',
            ],
            'expired_date'    => [
                'string',
                'nullable',
            ],
            'project_code_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
