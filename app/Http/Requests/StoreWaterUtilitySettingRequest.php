<?php

namespace App\Http\Requests;

use App\Models\WaterUtilitySetting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreWaterUtilitySettingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('water_utility_setting_create');
    }

    public function rules()
    {
        return [
            'amount_per_consumption' => [
                'required',
            ],
        ];
    }
}
