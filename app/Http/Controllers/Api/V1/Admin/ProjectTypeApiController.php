<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectTypeRequest;
use App\Http\Requests\UpdateProjectTypeRequest;
use App\Http\Resources\Admin\ProjectTypeResource;
use App\Models\ProjectType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectTypeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('project_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProjectTypeResource(ProjectType::with(['category'])->get());
    }

    public function store(StoreProjectTypeRequest $request)
    {
        $projectType = ProjectType::create($request->all());

        return (new ProjectTypeResource($projectType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ProjectType $projectType)
    {
        abort_if(Gate::denies('project_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProjectTypeResource($projectType->load(['category']));
    }

    public function update(UpdateProjectTypeRequest $request, ProjectType $projectType)
    {
        $projectType->update($request->all());

        return (new ProjectTypeResource($projectType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ProjectType $projectType)
    {
        abort_if(Gate::denies('project_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projectType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
