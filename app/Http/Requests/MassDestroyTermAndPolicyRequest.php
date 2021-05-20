<?php

namespace App\Http\Requests;

use App\Models\TermAndPolicy;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTermAndPolicyRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('term_and_policy_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:term_and_policies,id',
        ];
    }
}
