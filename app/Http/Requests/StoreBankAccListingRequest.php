<?php

namespace App\Http\Requests;

use App\Models\BankAccListing;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBankAccListingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('bank_acc_listing_create');
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
            'project_code' => [
                'integer',
            ],
        ];
    }
}
