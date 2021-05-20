<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleBrandRequest;
use App\Http\Requests\UpdateVehicleBrandRequest;
use App\Http\Resources\Admin\VehicleBrandResource;
use App\Models\VehicleBrand;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VehicleBrandApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('vehicle_brand_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VehicleBrandResource(VehicleBrand::all());
    }

    public function store(StoreVehicleBrandRequest $request)
    {
        $vehicleBrand = VehicleBrand::create($request->all());

        return (new VehicleBrandResource($vehicleBrand))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(VehicleBrand $vehicleBrand)
    {
        abort_if(Gate::denies('vehicle_brand_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VehicleBrandResource($vehicleBrand);
    }

    public function update(UpdateVehicleBrandRequest $request, VehicleBrand $vehicleBrand)
    {
        $vehicleBrand->update($request->all());

        return (new VehicleBrandResource($vehicleBrand))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(VehicleBrand $vehicleBrand)
    {
        abort_if(Gate::denies('vehicle_brand_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleBrand->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
