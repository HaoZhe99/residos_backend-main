<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreDefectListingRequest;
use App\Http\Requests\UpdateDefectListingRequest;
use App\Http\Resources\Admin\DefectListingResource;
use App\Models\DefectListing;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DefectListingApiController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('defect_listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $defectListing = DefectListing::with(['category', 'status_control', 'project_code']);

        if ($request->has('project_code_id')) {
            $defectListing->where('project_code_id', $request->project_code_id);
        }

        return new DefectListingResource($defectListing->get());
    }

    public function store(StoreDefectListingRequest $request)
    {
        $defectListing = DefectListing::create($request->all());

        if ($request->file('image', false)) {
            $defectListing->addMedia(/*storage_path('tmp/uploads/' . basename(*/$request->file('image')/*))*/)->toMediaCollection('image');
        }

        return (new DefectListingResource($defectListing))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DefectListing $defectListing)
    {
        abort_if(Gate::denies('defect_listing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DefectListingResource($defectListing->load(['category', 'status_control', 'project_code']));
    }

    public function update(UpdateDefectListingRequest $request, DefectListing $defectListing)
    {
        $defectListing->update($request->all());

        if ($request->file('image', false)) {
            if (!$defectListing->image || $request->file('image') !== $defectListing->image->file_name) {
                if ($defectListing->image) {
                    $defectListing->image->delete();
                }

                $defectListing->addMedia(/*storage_path('tmp/uploads/' . basename(*/$request->file('image')/*))*/)->toMediaCollection('image');
            }
        } elseif ($defectListing->image) {
            $defectListing->image->delete();
        }

        return (new DefectListingResource($defectListing))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DefectListing $defectListing)
    {
        abort_if(Gate::denies('defect_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $defectListing->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
