<?php

namespace App\Http\Requests;

use App\Models\WaterUtilityPayment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreWaterUtilityPaymentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('water_utility_payment_create');
    }

    public function rules()
    {
        return [
            'unit_owner_id' => [
                'required',
                'integer',
            ],
            'name'          => [
                'string',
                'nullable',
            ],
            'last_date'     => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'last_meter'    => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'this_meter'    => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'prev_consume'  => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'this_consume'  => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'variance'      => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            // 'amount'        => [
            //     'required',
            //     'integer',
            //     'min:-2147483648',
            //     'max:2147483647',
            // ],
            // 'status'        => [
            //     'required',
            // ],
        ];
    }
}
