<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreContentListingRequest;
use App\Http\Requests\UpdateContentListingRequest;
use App\Http\Resources\Admin\ContentListingResource;
use App\Models\ContentListing;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentListingApiController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('content_listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contentListing = ContentListing::with(['type', 'project_code']);

        if ($request->has('project_code_id')) {
            $contentListing->where('project_code_id', $request->project_code_id);
        }

        if ($request->has('type_id')) {
            $contentListing->where('type_id', $request->type_id);
        }

        if ($request->has('user_id')) {
            $alerts = User::find($request->user_id)->notification()->get();

            foreach ($alerts as $alert) {
                $pivot = $alert->pivot;

                if ($pivot->read == true) {
                    $alert['read'] = true;
                } else {
                    $alert['read'] = false;
                }
            }

            return new ContentListingResource($alerts);
        }

        return new ContentListingResource($contentListing->get());
    }

    public function store(Request $request)
    {
        $contentListing = ContentListing::create($request->all());

        if ($request->type_id == 2) {
            $contentListing->users()->sync($request->input('users', []));
        }

        if ($request->input('image', false)) {
            $contentListing->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        return (new ContentListingResource($contentListing))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ContentListing $contentListing)
    {
        abort_if(Gate::denies('content_listing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ContentListingResource($contentListing->load(['type', 'project_code']));
    }

    public function update(UpdateContentListingRequest $request, ContentListing $contentListing)
    {
        $contentListing->update($request->all());

        if ($request->input('image', false)) {
            if (!$contentListing->image || $request->input('image') !== $contentListing->image->file_name) {
                if ($contentListing->image) {
                    $contentListing->image->delete();
                }

                $contentListing->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($contentListing->image) {
            $contentListing->image->delete();
        }

        return (new ContentListingResource($contentListing))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ContentListing $contentListing)
    {
        abort_if(Gate::denies('content_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contentListing->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function read(Request $request)
    {
        if ($request->has('user_id') && $request->has('alert_id')) {
            $alert = User::find($request->user_id)->notification()
                ->where('notification_id', $request->alert_id)
                ->where('read', false)->first();

            if ($alert) {
                $pivot  = $alert->pivot;
                $pivot->read = true;
                $pivot->save();
            }

            $alert['read'] = true;

            return new ContentListingResource($alert);
        }
    }
}
