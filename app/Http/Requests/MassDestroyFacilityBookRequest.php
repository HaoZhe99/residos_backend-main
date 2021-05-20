<?php

namespace App\Http\Requests;

use App\Models\FacilityBook;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyFacilityBookRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('facility_book_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:facility_books,id',
        ];
    }
}
