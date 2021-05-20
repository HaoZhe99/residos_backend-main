<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\NotificationResource;
use App\Models\ContentListing;
use App\Models\Notification;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationApiController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('notification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // return new UserAlertResource(UserAlert::with(['users'])->get());

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

            return new NotificationResource($alerts);
        }

        return new NotificationResource(Notification::with(['users'])->get());
    }

    public function store(Request $request)
    {
        $userAlert = ContentListing::create($request->all());
        $userAlert->users()->sync($request->input('users', []));

        return (new NotificationResource($userAlert))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Notification $userAlert)
    {
        abort_if(Gate::denies('notification_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new NotificationResource($userAlert->load(['users']));
    }

    public function destroy(Notification $userAlert)
    {
        abort_if(Gate::denies('user_alert_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userAlert->delete();

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

            return new NotificationResource($alert);
        }
    }
}
