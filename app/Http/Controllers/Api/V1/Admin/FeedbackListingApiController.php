<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreFeedbackListingRequest;
use App\Http\Requests\UpdateFeedbackListingRequest;
use App\Http\Resources\Admin\FeedbackListingResource;
use App\Models\FeedbackListing;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FeedbackListingApiController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('feedback_listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feedbackListing = FeedbackListing::with(['category', 'project_code', 'created_by']);

        if ($request->has('project_code_id')) {
            $feedbackListing->where('project_code_id', $request->project_code_id);
        }

        return new FeedbackListingResource($feedbackListing->get());
    }

    public function store(StoreFeedbackListingRequest $request)
    {
        $feedbackListing = FeedbackListing::create($request->all());

        if ($request->file('reply_photo', false)) {
            $feedbackListing->addMedia(/*storage_path('tmp/uploads/' . basename(*/$request->file('reply_photo')/*))*/)->toMediaCollection('reply_photo');
        }

        if ($request->file('file', false)) {
            $feedbackListing->addMedia(/*storage_path('tmp/uploads/' . */$request->file('file')/*)*/)->toMediaCollection('file');
        }

        return (new FeedbackListingResource($feedbackListing))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(FeedbackListing $feedbackListing)
    {
        abort_if(Gate::denies('feedback_listing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FeedbackListingResource($feedbackListing->load(['category', 'project_code', 'created_by']));
    }

    public function update(UpdateFeedbackListingRequest $request, FeedbackListing $feedbackListing)
    {
        $feedbackListing->update($request->all());

        if ($request->file('reply_photo', false)) {
            // dd("hi");
            if (!$feedbackListing->reply_photo || $request->file('reply_photo') !== $feedbackListing->reply_photo->file_name) {
                if ($feedbackListing->reply_photo) {
                    $feedbackListing->reply_photo->delete();
                }

                $feedbackListing->addMedia(/*storage_path('tmp/uploads/' . */$request->file('reply_photo')/*)*/)->toMediaCollection('reply_photo');
            }
        }
        // elseif ($feedbackListing->reply_photo) {
        //     $feedbackListing->reply_photo->delete();
        // }

        if ($request->file('file', false)) {
            if (!$feedbackListing->file || $request->file('file') !== $feedbackListing->file->file_name) {
                if ($feedbackListing->file) {
                    $feedbackListing->file->delete();
                }

                $feedbackListing->addMedia(/*storage_path('tmp/uploads/' . basename(*/$request->file('file')/*))*/)->toMediaCollection('file');
            }
        }
        // elseif ($feedbackListing->file) {
        //     $feedbackListing->file->delete();
        // }

        return (new FeedbackListingResource($feedbackListing))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(FeedbackListing $feedbackListing)
    {
        abort_if(Gate::denies('feedback_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feedbackListing->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
