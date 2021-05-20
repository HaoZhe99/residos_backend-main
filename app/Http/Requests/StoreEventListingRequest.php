<?php

namespace App\Http\Requests;

use App\Models\EventListing;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEventListingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('event_listing_create');
    }

    public function rules()
    {
        return [
            'event_code'   => [
                'string',
                'required',
            ],
            'catogery_id'  => [
                'required',
                'integer',
            ],
            'title'        => [
                'string',
                'required',
            ],
            'description'  => [
                'string',
                'required',
            ],
            'language'     => [
                'string',
                'required',
            ],
            'payment'      => [
                'string',
                'nullable',
            ],
            'participants' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'image.*'      => [
                'required',
            ],
            'organized_by' => [
                'string',
                'nullable',
            ],
            'type'         => [
                'string',
                'nullable',
            ],
            'status'       => [
                'required',
            ],
        ];
    }
}
