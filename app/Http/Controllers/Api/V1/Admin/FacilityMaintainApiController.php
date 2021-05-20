<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFacilityMaintainRequest;
use App\Http\Requests\UpdateFacilityMaintainRequest;
use App\Http\Resources\Admin\FacilityMaintainResource;
use App\Models\FacilityMaintain;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FacilityMaintainApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('facility_maintain_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FacilityMaintainResource(FacilityMaintain::with(['username', 'facility_code'])->get());
    }

    public function store(StoreFacilityMaintainRequest $request)
    {
        $facilityMaintain = FacilityMaintain::create($request->all());

        return (new FacilityMaintainResource($facilityMaintain))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(FacilityMaintain $facilityMaintain)
    {
        abort_if(Gate::denies('facility_maintain_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FacilityMaintainResource($facilityMaintain->load(['username', 'facility_code']));
    }

    public function update(UpdateFacilityMaintainRequest $request, FacilityMaintain $facilityMaintain)
    {
        $facilityMaintain->update($request->all());

        return (new FacilityMaintainResource($facilityMaintain))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(FacilityMaintain $facilityMaintain)
    {
        abort_if(Gate::denies('facility_maintain_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $facilityMaintain->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
