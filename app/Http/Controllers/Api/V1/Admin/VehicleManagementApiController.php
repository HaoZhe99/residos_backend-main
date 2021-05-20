<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleManagementRequest;
use App\Http\Requests\UpdateVehicleManagementRequest;
use App\Http\Resources\Admin\VehicleManagementResource;
use App\Models\VehicleManagement;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VehicleManagementApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('vehicle_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VehicleManagementResource(VehicleManagement::with(['user', 'carpark_location', 'model', 'brand'])->get());
    }

    public function store(StoreVehicleManagementRequest $request)
    {
        $vehicleManagement = VehicleManagement::create($request->all());

        return (new VehicleManagementResource($vehicleManagement))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(VehicleManagement $vehicleManagement)
    {
        abort_if(Gate::denies('vehicle_management_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VehicleManagementResource($vehicleManagement->load(['user', 'carpark_location', 'model', 'brand']));
    }

    public function update(UpdateVehicleManagementRequest $request, VehicleManagement $vehicleManagement)
    {
        $vehicleManagement->update($request->all());

        return (new VehicleManagementResource($vehicleManagement))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(VehicleManagement $vehicleManagement)
    {
        abort_if(Gate::denies('vehicle_management_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleManagement->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
