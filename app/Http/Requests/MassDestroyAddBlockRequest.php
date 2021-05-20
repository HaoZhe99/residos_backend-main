<?php

namespace App\Http\Requests;

use App\Models\AddBlock;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAddBlockRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('add_block_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:add_blocks,id',
        ];
    }
}
