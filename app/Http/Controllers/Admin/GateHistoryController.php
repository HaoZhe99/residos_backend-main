<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyGateHistoryRequest;
use App\Http\Requests\StoreGateHistoryRequest;
use App\Http\Requests\UpdateGateHistoryRequest;
use App\Models\GateHistory;
use App\Models\Gateway;
use App\Models\Qr;
use App\Models\UnitManagement;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class GateHistoryController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('gate_history_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = GateHistory::with(['username'])->select(sprintf('%s.*', (new GateHistory)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'gate_history_show';
                $editGate      = 'gate_history_edit';
                $deleteGate    = 'gate_history_delete';
                $crudRoutePart = 'gate-histories';

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
            $table->editColumn('gate_code', function ($row) {
                return $row->gate_code ? $row->gate_code : "";
            });
            $table->editColumn('type', function ($row) {
                return $row->type ? $row->type : "";
            });
            $table->addColumn('username_name', function ($row) {
                return $row->username ? $row->username->name : '';
            });
            $table->addColumn('gateway_name', function ($row) {
                return $row->gateway ? $row->gateway->name : '';
            });

            $table->addColumn('qr_code', function ($row) {
                return $row->qr ? $row->qr->code : '';
            });
            $table->addColumn('unit_unit_owner', function ($row) {
                return $row->unit ? $row->unit->unit_owner : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'username']);

            return $table->make(true);
        }

        return view('admin.gateHistories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('gate_history_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $usernames = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $gateways = Gateway::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $qrs = Qr::all()->pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = UnitManagement::all()->pluck('unit_owner', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.gateHistories.create', compact('usernames', 'gateways', 'qrs', 'units'));
    }

    public function store(StoreGateHistoryRequest $request)
    {
        $gateHistory = GateHistory::create($request->all());

        return redirect()->route('admin.gate-histories.index');
    }

    public function edit(GateHistory $gateHistory)
    {
        abort_if(Gate::denies('gate_history_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $usernames = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $gateways = Gateway::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $qrs = Qr::all()->pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $units = UnitManagement::all()->pluck('unit_owner', 'id')->prepend(trans('global.pleaseSelect'), '');

        $gateHistory->load('username', 'gateway', 'qr', 'unit');

        return view('admin.gateHistories.edit', compact('usernames', 'gateHistory', 'gateways', 'qrs', 'units'));
    }

    public function update(UpdateGateHistoryRequest $request, GateHistory $gateHistory)
    {
        $gateHistory->update($request->all());

        return redirect()->route('admin.gate-histories.index');
    }

    public function show(GateHistory $gateHistory)
    {
        abort_if(Gate::denies('gate_history_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gateHistory->load('username', 'gateway', 'qr', 'unit');

        return view('admin.gateHistories.show', compact('gateHistory'));
    }

    public function destroy(GateHistory $gateHistory)
    {
        abort_if(Gate::denies('gate_history_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gateHistory->delete();

        return back();
    }

    public function massDestroy(MassDestroyGateHistoryRequest $request)
    {
        GateHistory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
