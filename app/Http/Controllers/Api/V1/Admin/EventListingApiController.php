<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreEventListingRequest;
use App\Http\Requests\UpdateEventListingRequest;
use App\Http\Resources\Admin\EventListingResource;
use App\Models\EventListing;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventListingApiController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('event_listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventListing = EventListing::with(['catogery', 'created_by', 'user_group']);

        if ($request->has('category_id')) {
            $eventListing->where('category_id', $request->category_id);
        }

        return new EventListingResource($eventListing->get());
    }

    public function store(StoreEventListingRequest $request)
    {
        $eventListing = EventListing::create($request->all());

        if ($request->input('image', false)) {
            $eventListing->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        return (new EventListingResource($eventListing))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EventListing $eventListing)
    {
        abort_if(Gate::denies('event_listing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventListingResource($eventListing->load(['catogery', 'created_by', 'user_group']));
    }

    public function update(Request $request, EventListing $eventListing)
    {
        $eventListing->update($request->all());

        if ($request->file('image', false)) {
            if (!$eventListing->image || $request->file('image') !== $eventListing->image->file_name) {
                if ($eventListing->image) {
                    $eventListing->image->delete();
                }

                $eventListing->addMedia(storage_path('tmp/uploads/' . basename($request->file('image'))))->toMediaCollection('image');
            }
        } elseif ($eventListing->image) {
            $eventListing->image->delete();
        }

        return (new EventListingResource($eventListing))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EventListing $eventListing)
    {
        abort_if(Gate::denies('event_listing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventListing->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function update_participants(Request $request, $id)
    {
        $eventListing = EventListing::find($id);
        $eventListing->update(['participants' => $request->participants]);

        return (new EventListingResource($eventListing))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function paginate_event_data()
    {
        abort_if(Gate::denies('event_listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventListingResource(EventListing::with(['catogery', 'created_by', 'user_group'])->limit(4)->get());
    }

    public function add_paginate_event_data(Request $request)
    {
        abort_if(Gate::denies('event_listing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventListingResource(EventListing::with(['catogery', 'created_by', 'user_group'])->offset($request->skip)->limit($request->take)->get());
    }
}
