<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleModelRequest;
use App\Http\Requests\UpdateVehicleModelRequest;
use App\Http\Resources\Admin\VehicleModelResource;
use App\Models\VehicleModel;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VehicleModelApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('vehicle_model_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VehicleModelResource(VehicleModel::with(['brand'])->get());
    }

    public function store(StoreVehicleModelRequest $request)
    {
        $vehicleModel = VehicleModel::create($request->all());

        return (new VehicleModelResource($vehicleModel))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(VehicleModel $vehicleModel)
    {
        abort_if(Gate::denies('vehicle_model_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VehicleModelResource($vehicleModel->load(['brand']));
    }

    public function update(UpdateVehicleModelRequest $request, VehicleModel $vehicleModel)
    {
        $vehicleModel->update($request->all());

        return (new VehicleModelResource($vehicleModel))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(VehicleModel $vehicleModel)
    {
        abort_if(Gate::denies('vehicle_model_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleModel->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
