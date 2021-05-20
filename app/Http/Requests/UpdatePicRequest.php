<?php

namespace App\Http\Requests;

use App\Models\Pic;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePicRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('pic_edit');
    }

    public function rules()
    {
        return [
            'name'     => [
                'string',
                'required',
            ],
            'contact'  => [
                'string',
                'required',
            ],
            'email'    => [
                'string',
                'required',
            ],
            'position' => [
                'string',
                'required',
            ],
            'fb'       => [
                'string',
                'nullable',
            ],
        ];
    }
}
