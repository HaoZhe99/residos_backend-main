<?php

namespace App\Http\Requests;

use App\Models\AddUnit;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAddUnitRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('add_unit_create');
    }

    public function rules()
    {
        return [
            'unit'     => [
                'string',
                'required',
            ],
            'floor'    => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'block_id' => [
                'required',
                'integer',
            ],
            'square'   => [
                'numeric',
                'required',
            ],
            'meter'    => [
                'string',
                'required',
            ],
        ];
    }
}
