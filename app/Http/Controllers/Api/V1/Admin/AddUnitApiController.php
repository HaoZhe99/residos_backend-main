<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddUnitRequest;
use App\Http\Requests\UpdateAddUnitRequest;
use App\Http\Resources\Admin\AddUnitResource;
use App\Models\AddBlock;
use App\Models\AddUnit;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\UnitManagement;

class AddUnitApiController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('add_unit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // return new AddUnitResource(AddUnit::with(['block'])->get());

        $addUnits = AddUnit::with(['block', 'project_code']);

        if ($request->has('project_code_id')) {
            $addUnits->where('project_code_id', $request->project_code_id);
        }

        if ($request->has('block_id')) {
            $addUnits->where('block_id', $request->block_id);
        }

        if ($request->has('owner_id')) {
            $addUnits->whereNotIn('id', UnitManagement::select('unit_id')->where('owner_id', $request->owner_id));
            $addUnits->whereNotIn('id', UnitManagement::select('unit_id')->whereNotIn('status', [1, 3]));
        }

        return new AddUnitResource($addUnits->get());
    }

    public function store(StoreAddUnitRequest $request)
    {
        $addUnit = AddUnit::create($request->all());

        return (new AddUnitResource($addUnit))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AddUnit $addUnit)
    {
        abort_if(Gate::denies('add_unit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AddUnitResource($addUnit->load(['block', 'project_code']));
    }

    public function update(UpdateAddUnitRequest $request, AddUnit $addUnit)
    {
        $addUnit->update($request->all());

        return (new AddUnitResource($addUnit))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AddUnit $addUnit)
    {
        abort_if(Gate::denies('add_unit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $addUnit->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function unit_filter(Request $request)
    {
        $addBlock = AddBlock::with(['project_code']);
        $addUnits = AddUnit::with('block');

        if ($request->has('project_code')) {

            $addBlock = AddBlock::where('project_code_id', $request->project_code);

            $addUnits = AddUnit::where('block_id', $addBlock->pluck('id'));
        }
        return new AddUnitResource($addUnits->get());
    }
}
