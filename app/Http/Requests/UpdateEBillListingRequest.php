<?php

namespace App\Http\Requests;

use App\Models\EBillListing;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEBillListingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('e_bill_listing_edit');
    }

    public function rules()
    {
        return [
            'amount'       => [
                'string',
                'required',
            ],
            'expired_date' => [
                'string',
                'nullable',
            ],
            'remark'       => [
                'string',
                'nullable',
            ],
            'status'       => [
                'string',
                'nullable',
            ],
        ];
    }
}
