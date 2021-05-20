<?php

namespace App\Http\Requests;

use App\Models\DeveloperListing;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDeveloperListingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('developer_listing_edit');
    }

    public function rules()
    {
        return [
            'company_name' => [
                'string',
                'required',
            ],
            'contact'      => [
                'string',
                'nullable',
            ],
            'address'      => [
                'string',
                'nullable',
            ],
            'email'        => [
                'string',
                'nullable',
            ],
            'website'      => [
                'string',
                'nullable',
            ],
            'fb'           => [
                'string',
                'nullable',
            ],
            'linked_in'    => [
                'string',
                'nullable',
            ],
            'pic_id'       => [
                'required',
                'integer',
            ],
        ];
    }
}
