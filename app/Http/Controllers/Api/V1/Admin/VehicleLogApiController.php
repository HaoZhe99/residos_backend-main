<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleLogRequest;
use App\Http\Requests\UpdateVehicleLogRequest;
use App\Http\Resources\Admin\VehicleLogResource;
use App\Models\VehicleLog;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VehicleLogApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('vehicle_log_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VehicleLogResource(VehicleLog::with(['location'])->get());
    }

    public function store(StoreVehicleLogRequest $request)
    {
        $vehicleLog = VehicleLog::create($request->all());

        return (new VehicleLogResource($vehicleLog))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(VehicleLog $vehicleLog)
    {
        abort_if(Gate::denies('vehicle_log_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VehicleLogResource($vehicleLog->load(['location']));
    }

    public function update(UpdateVehicleLogRequest $request, VehicleLog $vehicleLog)
    {
        $vehicleLog->update($request->all());

        return (new VehicleLogResource($vehicleLog))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(VehicleLog $vehicleLog)
    {
        abort_if(Gate::denies('vehicle_log_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleLog->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
