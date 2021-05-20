<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarparklocationRequest;
use App\Http\Requests\UpdateCarparklocationRequest;
use App\Http\Resources\Admin\CarparklocationResource;
use App\Models\Carparklocation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CarparklocationApiController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('carparklocation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carparklocation = Carparklocation::with(['project_code']);

        if ($request->has('project_code_id')) {
            $carparklocation->where('project_code_id', $request->project_code_id);
        }

        return new CarparklocationResource($carparklocation->get());
    }

    public function store(StoreCarparklocationRequest $request)
    {
        $carparklocation = Carparklocation::create($request->all());

        return (new CarparklocationResource($carparklocation))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Carparklocation $carparklocation)
    {
        abort_if(Gate::denies('carparklocation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CarparklocationResource($carparklocation->load(['project_code']));
    }

    public function update(UpdateCarparklocationRequest $request, Carparklocation $carparklocation)
    {
        $carparklocation->update($request->all());

        return (new CarparklocationResource($carparklocation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Carparklocation $carparklocation)
    {
        abort_if(Gate::denies('carparklocation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carparklocation->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
