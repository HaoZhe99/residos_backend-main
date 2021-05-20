<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventCategoryRequest;
use App\Http\Requests\UpdateEventCategoryRequest;
use App\Http\Resources\Admin\EventCategoryResource;
use App\Models\EventCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventCategoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('event_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventCategoryResource(EventCategory::all());
    }

    public function store(StoreEventCategoryRequest $request)
    {
        $eventCategory = EventCategory::create($request->all());

        return (new EventCategoryResource($eventCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EventCategory $eventCategory)
    {
        abort_if(Gate::denies('event_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventCategoryResource($eventCategory);
    }

    public function update(UpdateEventCategoryRequest $request, EventCategory $eventCategory)
    {
        $eventCategory->update($request->all());

        return (new EventCategoryResource($eventCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EventCategory $eventCategory)
    {
        abort_if(Gate::denies('event_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
