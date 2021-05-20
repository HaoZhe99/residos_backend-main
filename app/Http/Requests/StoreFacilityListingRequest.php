<?php

namespace App\Http\Requests;

use App\Models\FacilityListing;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFacilityListingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('facility_listing_create');
    }

    public function rules()
    {
        return [
            'facility_code'   => [
                'string',
                'required',
            ],
            'name'            => [
                'string',
                'required',
            ],
            'desctiption'     => [
                'required',
            ],
            'status'          => [
                'required',
            ],
            'open'            => [
                'required',
                'date_format:' . config('panel.time_format'),
            ],
            'closed'          => [
                'required',
                'date_format:' . config('panel.time_format'),
            ],
            'category_id'     => [
                'required',
                'integer',
            ],
            'project_code_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
