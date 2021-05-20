<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectListingRequest;
use App\Http\Requests\UpdateProjectListingRequest;
use App\Http\Resources\Admin\ProjectListingResource;
use App\Models\ProjectListing;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectListingApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('project_listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProjectListingResource(ProjectListing::with(['type', 'developer', 'area', 'pic', 'user'])->get());
    }

    public function store(StoreProjectListingRequest $request)
    {
        $projectListing = ProjectListing::create($request->all());

        return (new ProjectListingResource($projectListing))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ProjectListing $projectListing)
    {
        abort_if(Gate::denies('project_listing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProjectListingResource($projectListing->load(['type', 'developer', 'area', 'pic', 'user']));
    }

    public function update(UpdateProjectListingRequest $request, ProjectListing $projectListing)
    {
        $projectListing->update($request->all());

        return (new ProjectListingResource($projectListing))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ProjectListing $projectListing)
    {
        abort_if(Gate::denies('project_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projectListing->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
