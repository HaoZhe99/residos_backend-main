<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTenantControlRequest;
use App\Http\Requests\UpdateTenantControlRequest;
use App\Http\Resources\Admin\TenantControlResource;
use App\Models\TenantControl;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\UnitManagement;

class TenantControlApiController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('tenant_control_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // return new TenantControlResource(TenantControl::with(['tenant', 'unit_owner'])->get());

        $tenantControls = TenantControl::with(['tenant', 'rent', 'rent.unit_owner.unit']);
        // return dd('hi');

        // if ($request->has('owner_id')) {
        //     foreach ($tenantControls as $tenantControl) {
        //         return dd($tenantControl->rent->unit_owner->owner_id);
        //     }
        //     $tenantControls->whereIn('rent_id', UnitManagement::select('id')->where('owner_id', $request->owner_id));
        // }

        if ($request->has('status')) {
            $tenantControls->where('status', $request->status);
        }

        return new TenantControlResource($tenantControls->get());
    }

    public function store(StoreTenantControlRequest $request)
    {
        $tenantControl = TenantControl::create($request->all());

        return (new TenantControlResource($tenantControl))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(TenantControl $tenantControl)
    {
        abort_if(Gate::denies('tenant_control_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TenantControlResource($tenantControl->load(['tenant', 'rent']));
    }

    public function update(UpdateTenantControlRequest $request, TenantControl $tenantControl)
    {
        $tenantControl->update($request->all());

        return (new TenantControlResource($tenantControl))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(TenantControl $tenantControl)
    {
        abort_if(Gate::denies('tenant_control_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tenantControl->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
