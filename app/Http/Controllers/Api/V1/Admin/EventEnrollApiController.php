<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventEnrollRequest;
use App\Http\Requests\UpdateEventEnrollRequest;
use App\Http\Resources\Admin\EventEnrollResource;
use App\Models\EventEnroll;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventEnrollApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('event_enroll_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventEnrollResource(EventEnroll::with(['username', 'event_code'])->get());
    }

    public function store(StoreEventEnrollRequest $request)
    {
        $eventEnroll = EventEnroll::create($request->all());

        return (new EventEnrollResource($eventEnroll))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EventEnroll $eventEnroll)
    {
        abort_if(Gate::denies('event_enroll_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventEnrollResource($eventEnroll->load(['username', 'event_code']));
    }

    public function update(UpdateEventEnrollRequest $request, EventEnroll $eventEnroll)
    {
        $eventEnroll->update($request->all());

        return (new EventEnrollResource($eventEnroll))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EventEnroll $eventEnroll)
    {
        abort_if(Gate::denies('event_enroll_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventEnroll->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
