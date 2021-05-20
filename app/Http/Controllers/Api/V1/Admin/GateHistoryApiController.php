<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGateHistoryRequest;
use App\Http\Requests\UpdateGateHistoryRequest;
use App\Http\Resources\Admin\GateHistoryResource;
use App\Models\GateHistory;
use App\Models\VisitorControl;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GateHistoryApiController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('gate_history_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $histories = GateHistory::with(['username', 'gateway', 'gateway.location_code_id', 'qr', 'unit']);

        if($request->has('username_id')){
            $histories->where('username_id', $request->username_id);
        }

        if($request->has('visitor')){
            $histories->whereIn('username_id', VisitorControl::select('username_id')->where('add_by_id', $request->visitor));
        }

        return new GateHistoryResource(GateHistory::with(['username'])->get());
    }

    public function store(StoreGateHistoryRequest $request)
    {
        $gateHistory = GateHistory::create($request->all());

        return (new GateHistoryResource($gateHistory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(GateHistory $gateHistory)
    {
        abort_if(Gate::denies('gate_history_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new GateHistoryResource($gateHistory->load(['username', 'gateway', 'qr', 'unit']));
    }

    public function update(UpdateGateHistoryRequest $request, GateHistory $gateHistory)
    {
        $gateHistory->update($request->all());

        return (new GateHistoryResource($gateHistory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(GateHistory $gateHistory)
    {
        abort_if(Gate::denies('gate_history_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gateHistory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
