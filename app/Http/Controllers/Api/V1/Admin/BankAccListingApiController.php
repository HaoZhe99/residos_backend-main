<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBankAccListingRequest;
use App\Http\Requests\UpdateBankAccListingRequest;
use App\Http\Resources\Admin\BankAccListingResource;
use App\Models\BankAccListing;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BankAccListingApiController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('bank_acc_listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bankAccListing = BankAccListing::with(['bank_name', 'project_code']);

        if ($request->has('project_code_id')) {
            $bankAccListing->where('project_code_id', $request->project_code_id);
        }

        return new BankAccListingResource($bankAccListing->get());
    }

    public function store(StoreBankAccListingRequest $request)
    {
        $bankAccListing = BankAccListing::create($request->all());
        $bankAccListing->project_codes()->sync($request->input('project_codes', []));

        return (new BankAccListingResource($bankAccListing))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(BankAccListing $bankAccListing)
    {
        abort_if(Gate::denies('bank_acc_listing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BankAccListingResource($bankAccListing->load(['bank_name', 'project_codes']));
    }

    public function update(UpdateBankAccListingRequest $request, BankAccListing $bankAccListing)
    {
        $bankAccListing->update($request->all());
        $bankAccListing->project_codes()->sync($request->input('project_codes', []));

        return (new BankAccListingResource($bankAccListing))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(BankAccListing $bankAccListing)
    {
        abort_if(Gate::denies('bank_acc_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bankAccListing->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
