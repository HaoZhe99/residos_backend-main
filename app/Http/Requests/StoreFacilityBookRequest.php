<?php

namespace App\Http\Requests;

use App\Models\FacilityBook;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFacilityBookRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('facility_book_create');
    }

    public function rules()
    {
        return [
            'date'             => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'time'             => [
                'required',
                'date_format:' . config('panel.time_format'),
            ],
            'status'           => [
                'string',
                'required',
            ],
            'username_id'      => [
                'required',
                'integer',
            ],
            'project_code_id'  => [
                'required',
                'integer',
            ],
            'facility_code_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
