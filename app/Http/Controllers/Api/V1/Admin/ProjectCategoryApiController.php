<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectCategoryRequest;
use App\Http\Requests\UpdateProjectCategoryRequest;
use App\Http\Resources\Admin\ProjectCategoryResource;
use App\Models\ProjectCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectCategoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('project_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProjectCategoryResource(ProjectCategory::all());
    }

    public function store(StoreProjectCategoryRequest $request)
    {
        $projectCategory = ProjectCategory::create($request->all());

        return (new ProjectCategoryResource($projectCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ProjectCategory $projectCategory)
    {
        abort_if(Gate::denies('project_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProjectCategoryResource($projectCategory);
    }

    public function update(UpdateProjectCategoryRequest $request, ProjectCategory $projectCategory)
    {
        $projectCategory->update($request->all());

        return (new ProjectCategoryResource($projectCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ProjectCategory $projectCategory)
    {
        abort_if(Gate::denies('project_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projectCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
