<?php

namespace App\Http\Requests;

use App\Models\WaterUtilitySetting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateWaterUtilitySettingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('water_utility_setting_edit');
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
