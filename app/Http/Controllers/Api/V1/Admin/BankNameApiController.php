<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBankNameRequest;
use App\Http\Requests\UpdateBankNameRequest;
use App\Http\Resources\Admin\BankNameResource;
use App\Models\BankName;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BankNameApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('bank_name_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BankNameResource(BankName::all());
    }

    public function store(StoreBankNameRequest $request)
    {
        $bankName = BankName::create($request->all());

        return (new BankNameResource($bankName))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(BankName $bankName)
    {
        abort_if(Gate::denies('bank_name_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BankNameResource($bankName);
    }

    public function update(UpdateBankNameRequest $request, BankName $bankName)
    {
        $bankName->update($request->all());

        return (new BankNameResource($bankName))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(BankName $bankName)
    {
        abort_if(Gate::denies('bank_name_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bankName->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
