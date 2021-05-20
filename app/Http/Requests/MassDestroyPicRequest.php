<?php

namespace App\Http\Requests;

use App\Models\Pic;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPicRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('pic_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:pics,id',
        ];
    }
}
