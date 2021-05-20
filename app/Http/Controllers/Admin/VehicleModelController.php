<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVehicleModelRequest;
use App\Http\Requests\StoreVehicleModelRequest;
use App\Http\Requests\UpdateVehicleModelRequest;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VehicleModelController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('vehicle_model_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VehicleModel::with(['brand'])->select(sprintf('%s.*', (new VehicleModel)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'vehicle_model_show';
                $editGate      = 'vehicle_model_edit';
                $deleteGate    = 'vehicle_model_delete';
                $crudRoutePart = 'vehicle-models';

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
            $table->addColumn('brand_brand', function ($row) {
                return $row->brand ? $row->brand->brand : '';
            });

            $table->editColumn('model', function ($row) {
                return $row->model ? $row->model : "";
            });
            $table->editColumn('is_enable', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_enable ? 'checked' : null) . '>';
            });
            $table->editColumn('type', function ($row) {
                return $row->type ? VehicleModel::TYPE_SELECT[$row->type] : '';
            });
            $table->editColumn('color', function ($row) {
                return $row->color ? $row->color : "";
            });
            $table->editColumn('variant', function ($row) {
                return $row->variant ? $row->variant : "";
            });
            $table->editColumn('series', function ($row) {
                return $row->series ? $row->series : "";
            });
            $table->editColumn('release_year', function ($row) {
                return $row->release_year ? $row->release_year : "";
            });
            $table->editColumn('seat_capacity', function ($row) {
                return $row->seat_capacity ? $row->seat_capacity : "";
            });
            $table->editColumn('length', function ($row) {
                return $row->length ? $row->length : "";
            });
            $table->editColumn('width', function ($row) {
                return $row->width ? $row->width : "";
            });
            $table->editColumn('height', function ($row) {
                return $row->height ? $row->height : "";
            });
            $table->editColumn('wheel_base', function ($row) {
                return $row->wheel_base ? $row->wheel_base : "";
            });
            $table->editColumn('kerb_weight', function ($row) {
                return $row->kerb_weight ? $row->kerb_weight : "";
            });
            $table->editColumn('fuel_tank', function ($row) {
                return $row->fuel_tank ? $row->fuel_tank : "";
            });
            $table->editColumn('front_brake', function ($row) {
                return $row->front_brake ? $row->front_brake : "";
            });
            $table->editColumn('rear_brake', function ($row) {
                return $row->rear_brake ? $row->rear_brake : "";
            });
            $table->editColumn('front_suspension', function ($row) {
                return $row->front_suspension ? $row->front_suspension : "";
            });
            $table->editColumn('rear_suspension', function ($row) {
                return $row->rear_suspension ? $row->rear_suspension : "";
            });
            $table->editColumn('steering', function ($row) {
                return $row->steering ? $row->steering : "";
            });
            $table->editColumn('engine_cc', function ($row) {
                return $row->engine_cc ? $row->engine_cc : "";
            });
            $table->editColumn('compression_ratio', function ($row) {
                return $row->compression_ratio ? $row->compression_ratio : "";
            });
            $table->editColumn('peak_power_bhp', function ($row) {
                return $row->peak_power_bhp ? $row->peak_power_bhp : "";
            });
            $table->editColumn('peak_torque_nm', function ($row) {
                return $row->peak_torque_nm ? $row->peak_torque_nm : "";
            });
            $table->editColumn('engine_type', function ($row) {
                return $row->engine_type ? $row->engine_type : "";
            });
            $table->editColumn('fuel_type', function ($row) {
                return $row->fuel_type ? $row->fuel_type : "";
            });
            $table->editColumn('driven_wheel_drive', function ($row) {
                return $row->driven_wheel_drive ? $row->driven_wheel_drive : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'brand', 'is_enable']);

            return $table->make(true);
        }

        return view('admin.vehicleModels.index');
    }

    public function create()
    {
        abort_if(Gate::denies('vehicle_model_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $brands = VehicleBrand::all()->pluck('brand', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.vehicleModels.create', compact('brands'));
    }

    public function store(StoreVehicleModelRequest $request)
    {
        $vehicleModel = VehicleModel::create($request->all());

        return redirect()->route('admin.vehicle-models.index');
    }

    public function edit(VehicleModel $vehicleModel)
    {
        abort_if(Gate::denies('vehicle_model_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $brands = VehicleBrand::all()->pluck('brand', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicleModel->load('brand');

        return view('admin.vehicleModels.edit', compact('brands', 'vehicleModel'));
    }

    public function update(UpdateVehicleModelRequest $request, VehicleModel $vehicleModel)
    {
        $vehicleModel->update($request->all());

        return redirect()->route('admin.vehicle-models.index');
    }

    public function show(VehicleModel $vehicleModel)
    {
        abort_if(Gate::denies('vehicle_model_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleModel->load('brand');

        return view('admin.vehicleModels.show', compact('vehicleModel'));
    }

    public function destroy(VehicleModel $vehicleModel)
    {
        abort_if(Gate::denies('vehicle_model_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleModel->delete();

        return back();
    }

    public function massDestroy(MassDestroyVehicleModelRequest $request)
    {
        VehicleModel::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
