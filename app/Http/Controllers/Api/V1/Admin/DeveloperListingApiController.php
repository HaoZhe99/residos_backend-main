<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeveloperListingRequest;
use App\Http\Requests\UpdateDeveloperListingRequest;
use App\Http\Resources\Admin\DeveloperListingResource;
use App\Models\DeveloperListing;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeveloperListingApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('developer_listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DeveloperListingResource(DeveloperListing::with(['pic'])->get());
    }

    public function store(StoreDeveloperListingRequest $request)
    {
        $developerListing = DeveloperListing::create($request->all());

        return (new DeveloperListingResource($developerListing))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DeveloperListing $developerListing)
    {
        abort_if(Gate::denies('developer_listing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DeveloperListingResource($developerListing->load(['pic']));
    }

    public function update(UpdateDeveloperListingRequest $request, DeveloperListing $developerListing)
    {
        $developerListing->update($request->all());

        return (new DeveloperListingResource($developerListing))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DeveloperListing $developerListing)
    {
        abort_if(Gate::denies('developer_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $developerListing->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
