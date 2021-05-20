<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddBlockRequest;
use App\Http\Requests\UpdateAddBlockRequest;
use App\Http\Resources\Admin\AddBlockResource;
use App\Models\AddBlock;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddBlockApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('add_block_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AddBlockResource(AddBlock::with(['project_code'])->get());
    }

    public function store(StoreAddBlockRequest $request)
    {
        $addBlock = AddBlock::create($request->all());

        return (new AddBlockResource($addBlock))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AddBlock $addBlock)
    {
        abort_if(Gate::denies('add_block_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AddBlockResource($addBlock->load(['project_code']));
    }

    public function update(UpdateAddBlockRequest $request, AddBlock $addBlock)
    {
        $addBlock->update($request->all());

        return (new AddBlockResource($addBlock))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AddBlock $addBlock)
    {
        abort_if(Gate::denies('add_block_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $addBlock->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
