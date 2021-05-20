<?php

namespace App\Http\Requests;

use App\Models\Rent;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateRentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('rent_edit');
    }

    public function rules()
    {
        return [
            // 'tenant_id'      => [
            //     // 'required',
            //     'integer',
            // ],
            'rent_fee'          => [
                'required',
            ],
            'status'        => [
                'required',
            ],
            'type'          => [
                'required',
            ],
            'slot_limit'    => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'room_size'     => [
                'numeric',
            ],
            'remark'        => [
                'string',
                'nullable',
            ],
            'unit_owner_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
