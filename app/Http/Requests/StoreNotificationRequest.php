<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreNotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('notifications_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title_text'        => [
                'array',
                'required',
            ],
            'description_text'  => [
                'array',
                'required',
            ],
            'image'             => [
                'required',
            ],
            'language_shortkey' => [
                'array',
                'required',
            ],
            'url'               => [
                'string',
                'required',
            ],
            'role_id'           => [
                'array',
            ],
            'user_id'           => [
                'string',
            ],
            'expired_date'      => [
                'string',
                'required',
            ],
            'is_active'         => [
                'string',
            ]
        ];
    }
}
