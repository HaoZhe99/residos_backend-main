<?php

namespace App\Http\Requests;

use App\Models\DefectListing;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDefectListingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('defect_listing_create');
    }

    public function rules()
    {
        return [
            'case_code'       => [
                'string',
                'required',
            ],
            'category_id'     => [
                'required',
                'integer',
            ],
            'description'     => [
                'string',
                'required',
            ],
            'image.*'         => [
                'required',
            ],
            'date'            => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'time'            => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'remark'          => [
                'string',
                'nullable',
            ],
            'incharge_person' => [
                'string',
                'nullable',
            ],
            'contractor'      => [
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
