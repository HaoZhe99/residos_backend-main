<?php

namespace App\Http\Requests;

use App\Models\Carparklocation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCarparklocationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('carparklocation_edit');
    }

    public function rules()
    {
        return [
            'location'      => [
                'string',
                'required',
            ],
            'location_code' => [
                'string',
                'required',
            ],
        ];
    }
}
