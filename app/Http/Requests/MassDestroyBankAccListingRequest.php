<?php

namespace App\Http\Requests;

use App\Models\BankAccListing;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBankAccListingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('bank_acc_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:bank_acc_listings,id',
        ];
    }
}
