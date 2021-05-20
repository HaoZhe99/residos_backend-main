<?php

namespace App\Http\Requests;

use App\Models\AddBlock;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAddBlockRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('add_block_edit');
    }

    public function rules()
    {
        return [
            'block'           => [
                'string',
                'required',
            ],
            'project_code_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
