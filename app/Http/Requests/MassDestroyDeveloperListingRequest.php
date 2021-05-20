<?php

namespace App\Http\Requests;

use App\Models\DeveloperListing;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDeveloperListingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('developer_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:developer_listings,id',
        ];
    }
}
