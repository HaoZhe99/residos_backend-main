<?php

namespace App\Http\Requests;

use App\Models\EventEnroll;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEventEnrollRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('event_enroll_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:event_enrolls,id',
        ];
    }
}
