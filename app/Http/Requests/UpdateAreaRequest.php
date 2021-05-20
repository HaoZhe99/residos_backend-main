<?php

namespace App\Http\Requests;

use App\Models\Area;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAreaRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('area_edit');
    }

    public function rules()
    {
        return [
            'country'  => [
                'string',
                'required',
            ],
            'states'   => [
                'string',
                'required',
            ],
            'area'     => [
                'string',
                'required',
            ],
            'postcode' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
