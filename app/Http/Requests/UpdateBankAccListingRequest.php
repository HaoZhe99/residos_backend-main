<?php

namespace App\Http\Requests;

use App\Models\BankAccListing;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBankAccListingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('bank_acc_listing_edit');
    }

    public function rules()
    {
        return [
            'bank_account'    => [
                'string',
                'required',
            ],
            'status'          => [
                'string',
                'nullable',
            ],
            'project_codes.*' => [
                'integer',
            ],
            'project_codes'   => [
                'array',
            ],
        ];
    }
}
