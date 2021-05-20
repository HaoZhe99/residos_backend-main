<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVehicleLogRequest;
use App\Http\Requests\StoreVehicleLogRequest;
use App\Http\Requests\UpdateVehicleLogRequest;
use App\Models\Location;
use App\Models\VehicleLog;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VehicleLogController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('vehicle_log_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VehicleLog::with(['location'])->select(sprintf('%s.*', (new VehicleLog)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'vehicle_log_show';
                $editGate      = 'vehicle_log_edit';
                $deleteGate    = 'vehicle_log_delete';
                $crudRoutePart = 'vehicle-logs';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('car_plate', function ($row) {
                return $row->car_plate ? $row->car_plate : "";
            });
            $table->addColumn('location_location_code', function ($row) {
                return $row->location ? $row->location->location_code : '';
            });

            $table->editColumn('time_in', function ($row) {
                return $row->time_in ? $row->time_in : "";
            });
            $table->editColumn('time_out', function ($row) {
                return $row->time_out ? $row->time_out : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'location']);

            return $table->make(true);
        }

        return view('admin.vehicleLogs.index');
    }

    public function create()
    {
        abort_if(Gate::denies('vehicle_log_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $locations = Location::all()->pluck('location_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.vehicleLogs.create', compact('locations'));
    }

    public function store(StoreVehicleLogRequest $request)
    {
        $vehicleLog = VehicleLog::create($request->all());

        return redirect()->route('admin.vehicle-logs.index');
    }

    public function edit(VehicleLog $vehicleLog)
    {
        abort_if(Gate::denies('vehicle_log_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $locations = Location::all()->pluck('location_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicleLog->load('location');

        return view('admin.vehicleLogs.edit', compact('locations', 'vehicleLog'));
    }

    public function update(UpdateVehicleLogRequest $request, VehicleLog $vehicleLog)
    {
        $vehicleLog->update($request->all());

        return redirect()->route('admin.vehicle-logs.index');
    }

    public function show(VehicleLog $vehicleLog)
    {
        abort_if(Gate::denies('vehicle_log_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleLog->load('location');

        return view('admin.vehicleLogs.show', compact('vehicleLog'));
    }

    public function destroy(VehicleLog $vehicleLog)
    {
        abort_if(Gate::denies('vehicle_log_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleLog->delete();

        return back();
    }

    public function massDestroy(MassDestroyVehicleLogRequest $request)
    {
        VehicleLog::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
