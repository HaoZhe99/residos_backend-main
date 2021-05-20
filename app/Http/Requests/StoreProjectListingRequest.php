<?php

namespace App\Http\Requests;

use App\Models\ProjectListing;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreProjectListingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('project_listing_create');
    }

    public function rules()
    {
        return [
            'project_code'    => [
                'string',
                'nullable',
            ],
            'name'            => [
                'string',
                'required',
            ],
            'type_id'         => [
                'required',
                'integer',
            ],
            'address'         => [
                'string',
                'required',
            ],
            'developer_id'    => [
                'required',
                'integer',
            ],
            'tenure'          => [
                'required',
            ],
            'completion_date' => [
                'string',
                'required',
            ],
            'status'          => [
                'required',
            ],
            'sales_gallery'   => [
                'string',
                'nullable',
            ],
            'website'         => [
                'string',
                'nullable',
            ],
            'fb'              => [
                'string',
                'nullable',
            ],
            'block'           => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'unit'            => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'area_id'         => [
                'required',
                'integer',
            ],
            'pic_id'          => [
                'nullable',
                'integer',
            ],
        ];
    }
}
