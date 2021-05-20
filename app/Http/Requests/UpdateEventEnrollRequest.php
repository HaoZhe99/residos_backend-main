<?php

namespace App\Http\Requests;

use App\Models\EventEnroll;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEventEnrollRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('event_enroll_edit');
    }

    public function rules()
    {
        return [
            'status'        => [
                'required',
            ],
            'event_code_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
