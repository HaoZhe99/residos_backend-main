<?php

namespace App\Http\Requests;

use App\Models\WaterUtilityPayment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyWaterUtilityPaymentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('water_utility_payment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:water_utility_payments,id',
        ];
    }
}
