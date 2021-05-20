<?php

namespace App\Http\Requests;

use App\Models\VehicleLog;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateVehicleLogRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('vehicle_log_edit');
    }

    public function rules()
    {
        return [
            'car_plate' => [
                'string',
                'nullable',
            ],
            'time_in'   => [
                'string',
                'nullable',
            ],
            'time_out'  => [
                'string',
                'nullable',
            ],
        ];
    }
}
