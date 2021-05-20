<?php

namespace App\Http\Requests;

use App\Models\VehicleModel;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateVehicleModelRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('vehicle_model_edit');
    }

    public function rules()
    {
        return [
            'brand_id'           => [
                'required',
                'integer',
            ],
            'model'              => [
                'string',
                'required',
            ],
            'color'              => [
                'string',
                'nullable',
            ],
            'variant'            => [
                'string',
                'nullable',
            ],
            'series'             => [
                'string',
                'nullable',
            ],
            'release_year'       => [
                'string',
                'nullable',
            ],
            'seat_capacity'      => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'length'             => [
                'string',
                'nullable',
            ],
            'width'              => [
                'string',
                'nullable',
            ],
            'height'             => [
                'string',
                'nullable',
            ],
            'wheel_base'         => [
                'string',
                'nullable',
            ],
            'kerb_weight'        => [
                'string',
                'nullable',
            ],
            'fuel_tank'          => [
                'string',
                'nullable',
            ],
            'front_brake'        => [
                'string',
                'nullable',
            ],
            'rear_brake'         => [
                'string',
                'nullable',
            ],
            'front_suspension'   => [
                'string',
                'nullable',
            ],
            'rear_suspension'    => [
                'string',
                'nullable',
            ],
            'steering'           => [
                'string',
                'nullable',
            ],
            'engine_cc'          => [
                'string',
                'nullable',
            ],
            'compression_ratio'  => [
                'string',
                'nullable',
            ],
            'peak_power_bhp'     => [
                'string',
                'nullable',
            ],
            'peak_torque_nm'     => [
                'string',
                'nullable',
            ],
            'engine_type'        => [
                'string',
                'nullable',
            ],
            'fuel_type'          => [
                'string',
                'nullable',
            ],
            'driven_wheel_drive' => [
                'string',
                'nullable',
            ],
        ];
    }
}
