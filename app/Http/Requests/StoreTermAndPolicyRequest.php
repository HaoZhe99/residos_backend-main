<?php

namespace App\Http\Requests;

use App\Models\TermAndPolicy;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTermAndPolicyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('term_and_policy_create');
    }

    public function rules()
    {
        return [
            'title_zh'   => [
                'string',
                'required',
            ],
            'title_en'   => [
                'string',
                'required',
            ],
            'title_ms'   => [
                'string',
                'required',
            ],
            'details_zh' => [
                'required',
            ],
            'details_en' => [
                'required',
            ],
            'details_ms' => [
                'required',
            ],
            'type'       => [
                'required',
            ],
        ];
    }
}
