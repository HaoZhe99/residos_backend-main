<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreFacilityListingRequest;
use App\Http\Requests\UpdateFacilityListingRequest;
use App\Http\Resources\Admin\FacilityListingResource;
use App\Models\FacilityListing;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FacilityListingApiController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('facility_listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $facilityListing = FacilityListing::with(['category', 'project_code']);

        if ($request->has('project_code_id')) {
            $facilityListing->where('project_code_id', $request->project_code_id);
        }

        if ($request->has('category_id')) {
            $facilityListing->where('category_id', $request->category_id);
        }

        return new FacilityListingResource($facilityListing->get());
    }

    public function store(StoreFacilityListingRequest $request)
    {
        $facilityListing = FacilityListing::create($request->all());

        if ($request->input('image', false)) {
            $facilityListing->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        return (new FacilityListingResource($facilityListing))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(FacilityListing $facilityListing)
    {
        abort_if(Gate::denies('facility_listing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FacilityListingResource($facilityListing->load(['category', 'project_code']));
    }

    public function update(UpdateFacilityListingRequest $request, FacilityListing $facilityListing)
    {
        $facilityListing->update($request->all());

        if ($request->input('image', false)) {
            if (!$facilityListing->image || $request->input('image') !== $facilityListing->image->file_name) {
                if ($facilityListing->image) {
                    $facilityListing->image->delete();
                }

                $facilityListing->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($facilityListing->image) {
            $facilityListing->image->delete();
        }

        return (new FacilityListingResource($facilityListing))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(FacilityListing $facilityListing)
    {
        abort_if(Gate::denies('facility_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $facilityListing->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
