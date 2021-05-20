<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFamilyControlRequest;
use App\Http\Requests\UpdateFamilyControlRequest;
use App\Http\Resources\Admin\FamilyControlResource;
use App\Models\FamilyControl;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\UnitManagement;
use App\Models\UnitSetting;

class FamilyControlApiController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('family_control_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // return new FamilyControlResource(FamilyControl::with(['family', 'unit_owner'])->get());

        $familyControls = FamilyControl::with(['family', 'unit_owner', 'unit_owner.unit']);

        if($request->has('owner_id')){
            $familyControls->whereIn('unit_owner_id', UnitManagement::select('id')->where('owner_id', $request->owner_id));
        }

        return new FamilyControlResource($familyControls->get());
    }

    public function store(StoreFamilyControlRequest $request)
    {
        // UnitSetting::select('number_of_people_per_unit'); 
        $familyControl = FamilyControl::create($request->all());

        return (new FamilyControlResource($familyControl))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(FamilyControl $familyControl)
    {
        abort_if(Gate::denies('family_control_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FamilyControlResource($familyControl->load(['family', 'unit_owner']));
    }

    public function update(UpdateFamilyControlRequest $request, FamilyControl $familyControl)
    {
        $familyControl->update($request->all());

        return (new FamilyControlResource($familyControl))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(FamilyControl $familyControl)
    {
        abort_if(Gate::denies('family_control_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $familyControl->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
