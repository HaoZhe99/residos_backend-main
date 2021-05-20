<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreUnitMangementRequest;
use App\Http\Requests\UpdateUnitMangementRequest;
use App\Http\Resources\Admin\UnitMangementResource;
use App\Models\AddUnit;
use App\Models\UnitManagement;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UnitMangementApiController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('unit_mangement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitManagement = UnitManagement::with(['project_code', 'unit', 'owner']);

        if ($request->has('project_code_id')) {
            $unitManagement->where('project_code_id', $request->project_code_id);
        }

        return new UnitMangementResource($unitManagement->get());
    }

    public function store(StoreUnitMangementRequest $request)
    {
        $unitMangement = UnitManagement::create($request->all());

        if ($request->file('spa', false)) {
            $unitMangement->addMedia(/*storage_path('tmp/uploads/' . */$request->file('spa')/*)*/)->toMediaCollection('spa');
        }

        return (new UnitMangementResource($unitMangement))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(UnitManagement $unitMangement)
    {
        abort_if(Gate::denies('unit_mangement_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UnitMangementResource($unitMangement->load(['project_code', 'unit', 'owner']));
    }

    public function update(Request $request, UnitManagement $unitMangement)
    {
        $unitMangement->update($request->all());

        if ($request->file('spa', false)) {
            if (!$unitMangement->spa || $request->file('spa') !== $unitMangement->spa->file_name) {
                if ($unitMangement->spa) {
                    $unitMangement->spa->delete();
                }

                $unitMangement->addMedia(/*storage_path('tmp/uploads/' . basename(*/$request->file('spa')/*))*/)->toMediaCollection('spa');
            }
        } elseif ($unitMangement->spa) {
            $unitMangement->spa->delete();
        }

        return (new UnitMangementResource($unitMangement))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(UnitManagement $unitMangement)
    {
        abort_if(Gate::denies('unit_mangement_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitMangement->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function addUnit(Request $request)
    {
        $unit = AddUnit::find($request->unit_id)->load(['block']);
        $user = User::find($request->owner_id);

        $unitManagement = UnitManagement::create([
            'unit_id'     => $request->unit_id,
            'owner_id'    => $request->owner_id,
            'floor_size'    => $request->floor_size,
            'bed_room'    => $request->bed_room,
            'toilet'    => $request->toilet,
            'project_code_id'    => $request->project_code_id,
            'status'      => 'pending',
            'unit_owner'  => $unit->block->block . $unit->floor . $unit->unit . ' - ' . $user->name,
            'limit'       => '3',
        ]);

        if ($request->file('spa', false)) {
            $unitManagement->addMedia(/*storage_path('tmp/uploads/' . */$request->file('spa')/*)*/)->toMediaCollection('spa');
        }

        return (new UnitMangementResource($unitManagement))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update_status(Request $request, $id)
    {
        $unitMangement = UnitManagement::find($id);
        $unitMangement->update(['status' => $request->status]);

        return (new UnitMangementResource($unitMangement))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    // public function applyUnitMember(Request $request){
    //     // dd($unitManagement);
    //      $unitManagement = UnitManagement::find($request->id);
    //     // $unitManagement->update(['apply_unit_member' => 1]);

    //     return (new UnitManagementResource($unitManagement))
    //         ->response()
    //         ->setStatusCode(Response::HTTP_ACCEPTED);
    // }
}
