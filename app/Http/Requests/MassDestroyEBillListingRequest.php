<?php

namespace App\Http\Requests;

use App\Models\EBillListing;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEBillListingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('e_bill_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:e_bill_listings,id',
        ];
    }
}
