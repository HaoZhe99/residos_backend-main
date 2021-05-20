<?php

namespace App\Http\Requests;

use App\Models\DefectCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDefectCategoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('defect_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:defect_categories,id',
        ];
    }
}
