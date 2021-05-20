<?php

namespace App\Http\Requests;

use App\Models\VehicleManagement;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVehicleManagementRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('vehicle_management_create');
    }

    public function rules()
    {
        return [
            'car_plate' => [
                'string',
                'required',
            ],
            'color'     => [
                'string',
                'nullable',
            ],
            'driver'    => [
                'string',
                'nullable',
            ],
        ];
    }
}
