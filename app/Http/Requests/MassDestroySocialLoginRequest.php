<?php

namespace App\Http\Requests;

use App\Models\SocialLogin;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySocialLoginRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('social_login_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:societies_logins,id',
        ];
    }
}
