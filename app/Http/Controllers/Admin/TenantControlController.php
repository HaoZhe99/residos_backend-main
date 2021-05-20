<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTenantControlRequest;
use App\Http\Requests\StoreTenantControlRequest;
use App\Http\Requests\UpdateTenantControlRequest;
use App\Models\Rent;
use App\Models\TenantControl;
use App\Models\UnitManagement;
use App\Models\UnitMangement;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TenantControlController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('tenant_control_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TenantControl::with(['tenant', 'rent'])->select(sprintf('%s.*', (new TenantControl)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'tenant_control_show';
                $editGate      = 'tenant_control_edit';
                $deleteGate    = 'tenant_control_delete';
                $crudRoutePart = 'tenant-controls';

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
            $table->addColumn('tenant_name', function ($row) {
                return $row->tenant ? $row->tenant->name : '';
            });

            $table->addColumn('rent', function ($row) {
                return $row->rent ? $row->rent->unit_owner->unit_code : '';
            });

            $table->editColumn('status', function ($row) {
                return $row->status ? TenantControl::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'tenant', 'rent']);

            return $table->make(true);
        }

        return view('admin.tenantControls.index');
    }

    public function create()
    {
        abort_if(Gate::denies('tenant_control_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tenants = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $rents = Rent::all()->pluck('unit_owner.unit_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.tenantControls.create', compact('tenants', 'rents'));
    }

    public function store(StoreTenantControlRequest $request)
    {
        $tenantControl = TenantControl::create($request->all());

        return redirect()->route('admin.tenant-controls.index');
    }

    public function edit(TenantControl $tenantControl)
    {
        abort_if(Gate::denies('tenant_control_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tenants = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $rents = Rent::all()->pluck('unit_owner.unit_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tenantControl->load('tenant', 'rent');

        return view('admin.tenantControls.edit', compact('tenants', 'rents', 'tenantControl'));
    }

    public function update(UpdateTenantControlRequest $request, TenantControl $tenantControl)
    {
        $tenantControl->update($request->all());

        return redirect()->route('admin.tenant-controls.index');
    }

    public function show(TenantControl $tenantControl)
    {
        abort_if(Gate::denies('tenant_control_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tenantControl->load('tenant', 'rent');

        return view('admin.tenantControls.show', compact('tenantControl'));
    }

    public function destroy(TenantControl $tenantControl)
    {
        abort_if(Gate::denies('tenant_control_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tenantControl->delete();

        return back();
    }

    public function massDestroy(MassDestroyTenantControlRequest $request)
    {
        TenantControl::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
