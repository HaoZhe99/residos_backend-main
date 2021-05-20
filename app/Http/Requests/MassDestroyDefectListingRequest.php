<?php

namespace App\Http\Requests;

use App\Models\DefectListing;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDefectListingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('defect_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:defect_listings,id',
        ];
    }
}
