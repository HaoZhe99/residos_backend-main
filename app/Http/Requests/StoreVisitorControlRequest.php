<?php

namespace App\Http\Requests;

use App\Models\VisitorControl;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVisitorControlRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('visitor_control_create');
    }

    public function rules()
    {
        return [
            'username_id' => [
                'required',
                'integer',
            ],
            'add_by_id'   => [
                'required',
                'integer',
            ],
            'status'      => [
                'required',
            ],
        ];
    }
}
