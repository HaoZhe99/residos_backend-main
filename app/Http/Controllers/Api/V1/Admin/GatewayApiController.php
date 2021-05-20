<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGatewayRequest;
use App\Http\Requests\UpdateGatewayRequest;
use App\Http\Resources\Admin\GatewayResource;
use App\Models\Gateway;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GatewayApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('gateway_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new GatewayResource(Gateway::with(['location_code'])->get());
    }

    public function store(StoreGatewayRequest $request)
    {
        $gateway = Gateway::create($request->all());

        return (new GatewayResource($gateway))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Gateway $gateway)
    {
        abort_if(Gate::denies('gateway_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new GatewayResource($gateway->load(['location_code']));
    }

    public function update(UpdateGatewayRequest $request, Gateway $gateway)
    {
        $gateway->update($request->all());

        return (new GatewayResource($gateway))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Gateway $gateway)
    {
        abort_if(Gate::denies('gateway_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gateway->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
