<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyGatewayRequest;
use App\Http\Requests\StoreGatewayRequest;
use App\Http\Requests\UpdateGatewayRequest;
use App\Models\Gateway;
use App\Models\Location;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class GatewayController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('gateway_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Gateway::with(['location_code'])->select(sprintf('%s.*', (new Gateway)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'gateway_show';
                $editGate      = 'gateway_edit';
                $deleteGate    = 'gateway_delete';
                $crudRoutePart = 'gateways';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('last_active', function ($row) {
                return $row->last_active ? $row->last_active : "";
            });
            $table->editColumn('in_enable', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->in_enable ? 'checked' : null) . '>';
            });
            $table->editColumn('guard', function ($row) {
                return $row->guard ? $row->guard : "";
            });
            $table->addColumn('location_code_location_code', function ($row) {
                return $row->location_code ? $row->location_code->location_code : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'in_enable', 'location_code']);

            return $table->make(true);
        }

        return view('admin.gateways.index');
    }

    public function create()
    {
        abort_if(Gate::denies('gateway_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $location_codes = Location::all()->pluck('location_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.gateways.create', compact('location_codes'));
    }

    public function store(StoreGatewayRequest $request)
    {
        $gateway = Gateway::create($request->all());

        return redirect()->route('admin.gateways.index');
    }

    public function edit(Gateway $gateway)
    {
        abort_if(Gate::denies('gateway_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $location_codes = Location::all()->pluck('location_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $gateway->load('location_code');

        return view('admin.gateways.edit', compact('location_codes', 'gateway'));
    }

    public function update(UpdateGatewayRequest $request, Gateway $gateway)
    {
        $gateway->update($request->validated());

        return redirect()->route('admin.gateways.index');
    }

    public function show(Gateway $gateway)
    {
        abort_if(Gate::denies('gateway_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gateway->load('location_code');

        return view('admin.gateways.show', compact('gateway'));
    }

    public function destroy(Gateway $gateway)
    {
        abort_if(Gate::denies('gateway_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gateway->delete();

        return back();
    }

    public function massDestroy(MassDestroyGatewayRequest $request)
    {
        Gateway::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
