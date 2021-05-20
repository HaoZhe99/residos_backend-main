<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVehicleBrandRequest;
use App\Http\Requests\StoreVehicleBrandRequest;
use App\Http\Requests\UpdateVehicleBrandRequest;
use App\Models\VehicleBrand;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VehicleBrandController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('vehicle_brand_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VehicleBrand::query()->select(sprintf('%s.*', (new VehicleBrand)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'vehicle_brand_show';
                $editGate      = 'vehicle_brand_edit';
                $deleteGate    = 'vehicle_brand_delete';
                $crudRoutePart = 'vehicle-brands';

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
            $table->editColumn('brand', function ($row) {
                return $row->brand ? $row->brand : "";
            });
            $table->editColumn('is_enable', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_enable ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'is_enable']);

            return $table->make(true);
        }

        return view('admin.vehicleBrands.index');
    }

    public function create()
    {
        abort_if(Gate::denies('vehicle_brand_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.vehicleBrands.create');
    }

    public function store(StoreVehicleBrandRequest $request)
    {
        $vehicleBrand = VehicleBrand::create($request->all());

        return redirect()->route('admin.vehicle-brands.index');
    }

    public function edit(VehicleBrand $vehicleBrand)
    {
        abort_if(Gate::denies('vehicle_brand_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.vehicleBrands.edit', compact('vehicleBrand'));
    }

    public function update(UpdateVehicleBrandRequest $request, VehicleBrand $vehicleBrand)
    {
        $vehicleBrand->update($request->all());

        return redirect()->route('admin.vehicle-brands.index');
    }

    public function show(VehicleBrand $vehicleBrand)
    {
        abort_if(Gate::denies('vehicle_brand_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.vehicleBrands.show', compact('vehicleBrand'));
    }

    public function destroy(VehicleBrand $vehicleBrand)
    {
        abort_if(Gate::denies('vehicle_brand_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleBrand->delete();

        return back();
    }

    public function massDestroy(MassDestroyVehicleBrandRequest $request)
    {
        VehicleBrand::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
